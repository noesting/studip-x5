import * as Connection from '../general';

export const setInitialCustomLists = () => {
    return [{}];
};

export const setCustomListsFromDB = (customLists, recommendations, dozentViewContainer) => {
    const headers = Connection.getHeaders();
    const rangeId = Connection.getRangeId();

    return dozentViewContainer.$http
        .get(Connection.REST_ENDPOINT + 'courses/' + rangeId + '/x5lists', { headers })
        .then(response => handleGetListsResponse(response, customLists, recommendations, dozentViewContainer));
};

const handleGetListsResponse = (response, customLists, recommendations, dozentViewContainer) => {
    if (response.ok) {
        setCustomListsFromResponse(response, customLists, recommendations, dozentViewContainer);
    }
};

const setCustomListsFromResponse = (response, customLists, recommendations, dozentViewContainer) => {
    for (let i = 0; i < response.body.data.length; i++) {
        addListToArray(customLists, response.body.data[i], recommendations, dozentViewContainer);
    }
    customLists.shift();
};

const addListToArray = (customLists, data, recommendations, dozentViewContainer) => {
    customLists.push({
        id: data.id,
        title: data.attributes.title,
        list: []
    });

    setItems(customLists[customLists.length - 1], recommendations, dozentViewContainer);
};

const setItems = (customList, recommendations, dozentViewContainer) => {
    const headers = Connection.getHeaders();

    return dozentViewContainer.$http
        .get(Connection.REST_ENDPOINT + 'x5list/' + customList.id + '/items', { headers })
        .then(response => {
            if (response.ok) {
                for (let i = 0; i < response.body.data.relationships['x5-items'].meta.length; i++) {
                    const item = getItemFromRecommentdations(
                        response.body.data.relationships['x5-items'].meta[i].id,
                        recommendations
                    );
                    console.log('customList Item', item);
                    customList.list.push(item);
                }
            }
        });
};

const getItemFromRecommentdations = (itemId, recommendations) => {
    for (let i = 0; i < recommendations.length; i++) {
        if (recommendations[i].id === itemId) {
            return recommendations[i];
        }
    }
};

export const setStudentListsFromDB = (studentViewContainer, lists, recommendations) => {
    const headers = Connection.getHeaders();
    const rangeId = Connection.getRangeId();

    return studentViewContainer.$http
        .get(Connection.REST_ENDPOINT + 'x5lists/' + rangeId + '/student', { headers })
        .then(response => handleGetListsResponse(response, lists, recommendations, studentViewContainer));
};
