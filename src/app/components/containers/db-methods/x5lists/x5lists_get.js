import * as Connection from '../general';

export const setInitialCustomLists = () => {
    return [{}];
};

export const setCustomListsFromDB = (customLists, dozentViewContainer) => {
    const headers = Connection.getHeaders();
    const rangeId = Connection.getRangeId();

    return dozentViewContainer.$http
        .get(Connection.REST_ENDPOINT + 'x5lists/' + rangeId, { headers })
        .then(response => handleGetListsResponse(response, customLists));
};

const handleGetListsResponse = (response, customLists) => {
    if (response.ok) {
        setCustomListsFromResponse(response, customLists);
    }
};

const setCustomListsFromResponse = (response, customLists) => {
    for (let i = 0; i < response.body.data.length; i++) {
        addListToArray(customLists, response.body.data[i]);
    }
    customLists.shift();
};

const addListToArray = (customLists, data) => {
    customLists.push({
        id: data.id,
        title: data.attributes.title,
        list: []
    });
};
