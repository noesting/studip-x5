export const getX5Recommendations = (courseMetadata) => {
  // bundle Text parameter (String) for GET request
  bundleTextParameter(courseMetadata);
  // check for page and results count
  // GET request
  // handle GET request
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
  

