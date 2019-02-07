export const REST_ENDPOINT = 'http://localhost/studip-42/plugins.php/argonautsplugin/';

export const getHeaders = () => {
    const headers = {
        'Content-Type': 'application/json'
    };

    return headers;
};

export const getRangeId = () => {
    const currentUrl = window.location.href;
    const rangeId = currentUrl.split('?cid=')[1];

    return rangeId;
};
