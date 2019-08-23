import * as X5API from './x5api-config';
import VueJSModal from 'vue-js-modal';

export const getX5Recommendations = (courseMetadata, dozentViewContainer) => {
  // check for page and results count
  let textParameter = bundleTextParameter(courseMetadata);
  let recMaterial = getRequestX5Api(textParameter, dozentViewContainer).then(recommendations => {
    return recommendations;
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

const getRequestX5Api = (parameter, dozentViewContainer) => {
  let headers = X5API.getHeaders;

  return dozentViewContainer.$http
    .get(X5API.SEARCH_ENDPOINT + parameter, { headers })
    .then(response => handleX5GetResponse(response, dozentViewContainer));
};

const handleX5GetResponse = (response, dozentViewContainer) => {
  let recommendations = response.body.rec_materials;

  // This function renames the key 'material_id' to 'id'
  recommendations = renameObjectKeys(recommendations);
  // This function adds keys to recommendation items 
  // It's necessary to add those keys before assign the object to Vue-data to provide reactivity
  recommendations = addObjectKeys(recommendations);

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
