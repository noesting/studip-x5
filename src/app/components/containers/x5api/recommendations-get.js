import * as X5API from './x5api-config';

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
  return response.body.rec_materials;
};
