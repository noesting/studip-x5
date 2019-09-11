import * as X5API from './x5api-config';
import VueJSModal from 'vue-js-modal';

export const getX5RecommendationsByCourse = (courseMetadata, viewContainer) => {
  // check for page and results count
  let textParameter = bundleTextParameter(courseMetadata);
  let recMaterial = getRequestX5ApiSearch(textParameter, viewContainer).then(recommendations => {
    return recommendations;
  });
  return recMaterial;
};

export const getX5RecommendationsByText = (textParameter, viewContainer) => {
  let recMaterial = getRequestX5ApiSearch(textParameter, viewContainer).then(recommendations => {
    return recommendations;
  });
  return recMaterial;
};

export const getX5RecommendationById = (itemId, viewContainer) => {
  let recMaterial = getRequestX5ApiById(itemId, viewContainer).then(recommendation => {
    return recommendation;
  });
  return recMaterial;
};

const bundleTextParameter = (courseMetadata) => {
  //let keysToInclude = ['title', 'subtitle', 'description'];
  let keysToInclude = ['title', 'subtitle'];
  var textParameter = '';

  keysToInclude.forEach((key) => {
    if (courseMetadata[key] !== null || undefined || '')
      textParameter += courseMetadata[key] + ' ';
  });

  return textParameter;
};

const getRequestX5ApiSearch = (parameter, viewContainer) => {
  let headers = X5API.getHeaders;

  return viewContainer.$http
    .get(X5API.SEARCH_ENDPOINT + parameter, { headers })
    .then(response => handleX5GetResponse(response, viewContainer));
};

const getRequestX5ApiById = (itemId, viewContainer) => {
  let headers = X5API.getHeaders;

  return viewContainer.$http
    .get(X5API.BY_ID_ENDPOINT + itemId, { headers })
    .then(response => handleX5GetResponse(response, viewContainer));
};

const handleX5GetResponse = (response, viewContainer) => {
  let recommendations;
  if (response.body.rec_materials) {
    recommendations = response.body.rec_materials;
    recommendations = renameObjectKeys(recommendations);
    recommendations = addObjectKeys(recommendations);
  } else {
    recommendations = response.body.oer_materials;
    recommendations = addAndRenameObjectKeys(recommendations);
  };

  return recommendations;
};

const renameObjectKeys = (recommendations) => {
  for (let i = 0; i < recommendations.length; i++) {
    recommendations[i].id = recommendations[i].material_id;
    Reflect.deleteProperty(recommendations[i], 'material_id');
  }
  return recommendations;
};

const addObjectKeys = (recommendations) => {
  for (let i = 0; i < recommendations.length; i++) {
    recommendations[i].inList = false;
    recommendations[i].userRead = false;
    recommendations[i].userLiked = false;
    recommendations[i].thumbsUps = 0;
  };
  return recommendations;
};

const addAndRenameObjectKeys = (recommendations) => {
  recommendations.id = recommendations.material_id;
  Reflect.deleteProperty(recommendations, 'material_id');

  recommendations.userRead = false;
  recommendations.userLiked = false;
  recommendations.thumbsUps = 0;

  return recommendations;
};
