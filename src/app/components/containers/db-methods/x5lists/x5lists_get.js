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
        .then(response => enrichItems(response, recommendations, dozentViewContainer))
        .then(items => customList.list.push(...items))
        .catch(error => {
            console.error('Some Error occured', error);
        });
};

const enrichItems = (getItemsResponse, recommendations, vueComponent) => {
    const listItemsData = getItemsResponse.body.data.relationships['x5-items'].data;
    const listItemsMeta = getItemsResponse.body.data.relationships['x5-items'].meta;

    const itemsFromRecommendations = enrichFromRecommendations(listItemsData, recommendations);
    const commentedItems = enrichWithComments(itemsFromRecommendations, listItemsMeta);
    return enrichWithLikes(commentedItems, vueComponent);
};

const enrichFromRecommendations = (listItemsData, recommendations) => {
    return listItemsData.map(listItemData => {
        const item = getItemFromRecommendations(listItemData.id, recommendations);

        return { ...item };
    });
};

const getItemFromRecommendations = (itemId, recommendations) => {
    return recommendations.find(recommendation => {
        return recommendation.id === itemId;
    });
};

const enrichWithComments = (items, listItemsMeta) => {
    return items.map(item => {
        const itemComment = listItemsMeta.find(meta => {
            return meta.item_id === item.id;
        }).comment;

        return { ...item, comment: itemComment };
    });
};

const enrichWithLikes = (items, vueComponent) => {
    return Promise.all(getItemLikesAsPromises(items, vueComponent)).then(allItemLikes =>
        enrichWithLikesHandler(items, allItemLikes)
    );
};

const getItemLikesAsPromises = (commentedItems, vueComponent) => {
    return commentedItems.map(commentedItem => {
        return vueComponent.$http.get(Connection.REST_ENDPOINT + 'x5-items/' + commentedItem.id + '/users', {
            headers: Connection.getHeaders()
        });
    });
};

const enrichWithLikesHandler = (commentedItems, allItemLikesJSON) => {
    allItemLikesJSON.forEach((itemLikeJSON, index) => {
        const itemLike = itemLikeJSON.body.meta;
        commentedItems[index].thumbsUps = itemLike.likes;
        commentedItems[index].userLiked = itemLike.liked;
    });

    return commentedItems;
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

    enrichWithLikes(recommendations, dozentViewContainer);
};
