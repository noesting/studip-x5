export const SEARCH_ENDPOINT = `https://platform.x5gon.org/api/v1/search?text=`;

export const getHeaders = () => {
  const headers = {
      'Content-Type': 'application/json',
      'Access-Control-Allow-Origin': '*'
  };

  return headers;
};
