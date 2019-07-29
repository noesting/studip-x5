import * as Connection from '../general';

export const likeItem = (item, vueComponent) => {
    invokeCorrectFunction(item, vueComponent, 'like');
};

export const markItemAsRead = (item, vueComponent) => {
    if (!item.userRead) {
        invokeCorrectFunction(item, vueComponent, 'read');
    } 
};

const invokeCorrectFunction = (item, vueComponent, colToUpdate) => {
    if ((colToUpdate === 'like' && item.userLiked && !item.userRead) || (colToUpdate === 'read' && item.userLiked && !item.userRead)){
        deleteUserItem(item, vueComponent);
    } else if (!item.userLiked && !item.userRead) {
        createUserItem(item, vueComponent, colToUpdate);;
    } else {
        updateUserItem(item, vueComponent, colToUpdate); 
    }
};

const updateUserItem = (item, vueComponent, colToUpdate) => {
    vueComponent.$http
        .patch(Connection.REST_ENDPOINT + 'x5-user-items/' + item.id + "/update/" + colToUpdate, colToUpdate, {
            headers: Connection.getHeaders()
        })
        .then(response => {
            handleResponse(response, item, 'update');
        });
};

const deleteUserItem = (item, vueComponent) => {
    vueComponent.$http
        .delete(Connection.REST_ENDPOINT + 'x5-user-items/' + item.id, {
            headers: Connection.getHeaders()
        })
        .then(response => {
            handleResponse(response, item, 'delete');
        });
};

const createUserItem = (item, vueComponent, colToUpdate) => {
    vueComponent.$http
        .post(Connection.REST_ENDPOINT + 'x5-user-items/create', JSON.stringify(getUserItemJsonApiObject(item, colToUpdate)), {
            headers: Connection.getHeaders()
        })
        .then(response => {
            handleResponse(response, item, 'create');
        });
};

const getUserItemJsonApiObject = (item, colToUpdate) => {
    return {
        data: {
            type: 'x5-user-items',
            attributes: {
                likes: setCreateColState(colToUpdate, 'like'),
                read: setCreateColState(colToUpdate, 'read')
            },
            relationships: {
                'x5-item': {
                    type: 'x5-items',
                    id: item.id
                }
            }
        }
    };
};

const setCreateColState = (colToUpdate, keyName) => {
    if (colToUpdate === keyName)  {
        return true;
    } else if (colToUpdate === keyName) {
        return true;
    } else {
        return false;
    }
};

const handleResponse = (response, item, type) => {
    if (response.ok) {
        modifyItem(response, item, type);
    }
};

const modifyItem = (response, item, type) => {
    item.userLiked = Boolean(parseInt(response.body.data.attributes.likes));

    if (type === 'create' || type === 'update') {
        if (item.userLiked) {
            item.thumbsUps++;
        } else if (!item.userLiked && type === 'update') {
            item.thumbsUps--;
        }
    } else if (type === 'delete') {
        item.thumbsUps--;
    }
};
