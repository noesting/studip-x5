import * as Connection from '../general';

export const getCourseMetadata = (dozentViewContainer) => {
  const headers = Connection.getHeaders();
  const rangeId = Connection.getRangeId();

  return dozentViewContainer.$http
    .get(Connection.REST_ENDPOINT + 'courses/' + rangeId, { headers })
    .then(response => handleCourseMetadataResponse(response, dozentViewContainer));
};

const handleCourseMetadataResponse = (response, dozentViewContainer) => {
  if (response.ok) {
    return response.body;
  }
};
