// for development
export const REST_ENDPOINT = `${STUDIP.ABSOLUTE_URI_STUDIP}plugins.php/argonautsplugin/`;

// for test system
// export const REST_ENDPOINT = 'https://vm222.rz.uni-osnabrueck.de/studip/plugins.php/argonautsplugin/';

export const getHeaders = () => {
    const headers = {
        // 2019-07-04 ffeyen: Content-Typ header results in client side error 406 "Wrong Media Type" after JsonApiPlugin update
        //'Content-Type': 'application/json'
    };

    return headers;
};

export const getRangeId = () => {
    const currentUrl = window.location.href;
    const rangeId = currentUrl.split('?cid=')[1];

    return rangeId;
};
