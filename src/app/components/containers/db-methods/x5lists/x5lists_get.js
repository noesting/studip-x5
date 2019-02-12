import * as Connection from '../general';

export const setInitialCustomLists = () => {
    return [{}];
};

export const setCustomListsFromDB = (customLists, recommendations, dozentViewContainer) => {
    const headers = Connection.getHeaders();
    const rangeId = Connection.getRangeId();

    return dozentViewContainer.$http
        .get(Connection.REST_ENDPOINT + 'courses/' + rangeId + '/x5-lists', { headers })
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
        shared: data.attributes.visible,
        list: []
    });

    setItems(customLists[customLists.length - 1], recommendations, dozentViewContainer);
};

const setItems = (customList, recommendations, dozentViewContainer) => {
    const headers = Connection.getHeaders();

    return dozentViewContainer.$http
        .get(Connection.REST_ENDPOINT + 'x5-lists/' + customList.id + '/items', { headers })
        .then(response => {
            if (response.ok) {
                for (let i = 0; i < response.body.data.relationships['x5-items'].data.length; i++) {
                    const item = getItemFromRecommentdations(
                        response.body.data.relationships['x5-items'].data[i].id,
                        recommendations
                    );
                    const meta = response.body.data.relationships['x5-items'].meta.filter(m => {
                        return m.item_id === response.body.data.relationships['x5-items'].data[i].id;
                    })[0];

                    dozentViewContainer.$http
                        .get(Connection.REST_ENDPOINT + 'x5-items/' + item.id + '/users', { headers })
                        .then(likesResponse => {
                            if (likesResponse.ok) {
                                customList.list.push({
                                    ...item,
                                    ...{ comment: meta.comment },
                                    ...{
                                        thumbsUps: likesResponse.body.meta.likes,
                                        userLiked: likesResponse.body.meta.liked
                                    }
                                });
                            }
                        });
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
        .get(Connection.REST_ENDPOINT + 'courses/' + rangeId + '/x5-lists/student', { headers })
        .then(response => handleGetListsResponse(response, lists, recommendations, studentViewContainer));
};

export const enrichRecommendations = (dozentViewContainer, recommendations) => {
    if (!recommendations) {
        return;
    }

    const headers = Connection.getHeaders();

    for (let i = 0; i < recommendations.length; i++) {
        dozentViewContainer.$http
            .get(Connection.REST_ENDPOINT + 'x5-items/' + recommendations[i].id + '/users', { headers })
            .then(response => {
                if (response.ok) {
                    recommendations[i].thumbsUps = response.body.meta.likes;
                    recommendations[i].userLiked = response.body.meta.liked;
                }
            });
    }
};
