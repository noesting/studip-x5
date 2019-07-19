// for development jsonapi in core
export const REST_ENDPOINT = `${STUDIP.ABSOLUTE_URI_STUDIP}jsonapi.php/v1/`;

// for test system
// export const REST_ENDPOINT = 'https://vm222.rz.uni-osnabrueck.de/studip/plugins.php/argonautsplugin/';

export const getHeaders = () => {
    const headers = {
        'Content-Type': 'application/vnd.api+json'
    };

    return headers;
};

export const getRangeId = () => {
    const currentUrl = window.location.href;
    const rangeId = currentUrl.split('?cid=')[1];

    return rangeId;
};
