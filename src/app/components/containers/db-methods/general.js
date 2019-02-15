// for development
export const REST_ENDPOINT = 'http://localhost/studip-42/plugins.php/argonautsplugin/';

// for test system
// export const REST_ENDPOINT = 'https://vm222.rz.uni-osnabrueck.de/studip/plugins.php/argonautsplugin/';

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
