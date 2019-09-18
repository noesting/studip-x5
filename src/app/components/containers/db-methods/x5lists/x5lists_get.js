import * as Connection from '../general';
//import { resolve } from 'dns';

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
        return setCustomListsFromResponse(response, customLists, recommendations, dozentViewContainer);
    } else {
        return Promise.reject(new Error(response.status + ': ' + response.statusText));
    }
};

const setCustomListsFromResponse = (response, customLists, recommendations, dozentViewContainer) => {
    const promises = [];
    for (let i = 0; i < response.body.data.length; i++) {
        promises.push(addListToArray(customLists, response.body.data[i], recommendations, dozentViewContainer));
    }
    customLists.shift();
    return Promise.all(promises);
};

const addListToArray = (customLists, data, recommendations, dozentViewContainer) => {
    customLists.push({
        id: data.id,
        title: data.attributes.title,
        shared: data.attributes.visible,
        releaseDate: getReleaseDate(data),
        list: []
    });

    return setItems(customLists[customLists.length - 1], recommendations, dozentViewContainer);
};

const getReleaseDate = data => {
    if (data.attributes['release-date']) {
        return new Date(data.attributes['release-date']);
    }

    return new Date('1990-01-01');
};

const setItems = (customList, recommendations, dozentViewContainer) => {
    const headers = Connection.getHeaders();

    return dozentViewContainer.$http
        .get(Connection.REST_ENDPOINT + 'x5-lists/' + customList.id + '/items', { headers })
        .then(response => enrichItems(response, recommendations, dozentViewContainer))           
        .then(items => {
            customList.list.push(...items);
        })
        .catch(error => {
            console.error('Some Error occured', error);
        });
};

const enrichItems = (getItemsResponse, recommendations, vueComponent) => {
    const listItemsData = getItemsResponse.body.data.relationships['x5-items'].data;
    const listItemsMeta = getItemsResponse.body.data.relationships['x5-items'].meta;
    //console.log("listItemsData > " + JSON.stringify(listItemsData))
    //console.log("listItemsMeta > " + JSON.stringify(listItemsMeta))
    const itemsFromRecommendations = enrichFromRecommendations(listItemsData, recommendations, vueComponent);
    //console.log("itemsFromRecommendations > " + JSON.stringify(itemsFromRecommendations))
    const commentedItems = enrichWithComments(itemsFromRecommendations, listItemsMeta);
    //console.log("commentedItems > " + JSON.stringify(commentedItems))

    return enrichWithLikes(commentedItems, vueComponent);
};

const enrichFromRecommendations = (listItemsData, recommendations, vueComponent) => {
    return listItemsData.map(listItemData => {
        const item = getItemFromRecommendations(listItemData.id, recommendations, vueComponent);
        
        if (typeof item === 'undefined') {
            return { ...{ 
                'id': listItemData.id, 
                'dummy': true,
                'title': '',
                'description': '',
                'language': '',
                'provider': '',
                'type': '',
                'url': '',
                'extension': '',
                'license': ''
            } };
        } else {
            return { ...item };
        }
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
        enrichWithLikesAndReadHandler(items, allItemLikes)
    );
};

const getItemLikesAsPromises = (commentedItems, vueComponent) => {
    return commentedItems.map(commentedItem => {
        return vueComponent.$http.get(Connection.REST_ENDPOINT + 'x5-items/' + commentedItem.id + '/users', {
            headers: Connection.getHeaders()
        });
    });
};

const enrichWithLikesAndReadHandler = (commentedItems, allItemLikesJSON) => {
    allItemLikesJSON.forEach((itemLikeJSON, index) => {
        const itemLike = itemLikeJSON.body.meta;
        commentedItems[index].thumbsUps = itemLike.likes;
        commentedItems[index].userLiked = itemLike.liked;
        commentedItems[index].userRead = itemLike.read; 
    });

    return commentedItems;
};

export const setStudentListsFromDB = (lists, recommendations, studentViewContainer) => {
    const headers = Connection.getHeaders();
    const rangeId = Connection.getRangeId();

    return studentViewContainer.$http
        .get(Connection.REST_ENDPOINT + 'courses/' + rangeId + '/x5-lists/student', { headers })
        .then(response => {
            return handleGetListsResponse(response, lists, recommendations, studentViewContainer);
        })
        .catch(err => console.log(err));  
};

export const enrichRecommendations = (dozentViewContainer, recommendations) => {
    if (!recommendations) {
        return;
    }

    return enrichWithLikes(recommendations, dozentViewContainer);
};
