import * as X5API from './x5api-config';

export const getX5Recommendations = (courseMetadata, dozentViewContainer) => {
  // check for page and results count
  let parameter = bundleTextParameter(courseMetadata);
  console.log(parameter);
  let recommendations = getRequestX5Api(parameter, dozentViewContainer);
  console.log(recommendations);
  // bundle response
  // return response
};

const bundleTextParameter = (courseMetadata) => {
  let keysToInclude = ['title', 'subtitle', 'description'];
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
  console.log(response);
  return response;
};
  

