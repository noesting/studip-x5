export const SEARCH_ENDPOINT = `https://platform.x5gon.org/api/v1/search`;
export const BY_ID_ENDPOINT = 'https://platform.x5gon.org/api/v1/oer_materials/';
export const PREFETCH_RANGE = 2;

export const getHeaders = () => {
  const headers = {
      'Content-Type': 'application/json',
      'Access-Control-Allow-Origin': '*'
  };

  return headers;
};
