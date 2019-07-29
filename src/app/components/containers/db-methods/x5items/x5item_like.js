import * as Connection from '../general';

export const likeItem = (item, vueComponent) => {
    checkForOperationToPerform(item, vueComponent, 'like');
};

export const markItemAsRead = (item, vueComponent) => {
    if (!item.userRead) {
        checkForOperationToPerform(item, vueComponent, 'read');
    } 
};

const checkForOperationToPerform = (item, vueComponent, colToUpdate) => {
    if (colToUpdate === 'like' && item.userLiked && !item.userRead) {
        deleteUserItem(item, vueComponent);
    } else if (colToUpdate === 'read' && item.userLiked && !item.userRead) {
        deleteUserItem(item, vueComponent);
    } else if (item.userLiked || item.userRead) {
        if (colToUpdate === 'like') {
            updateUserItem(item, vueComponent, 'like');
        } else if (colToUpdate === 'read') {
            updateUserItem(item, vueComponent, 'read');
        }
    } else {
        createUserItem(item, vueComponent, colToUpdate);
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
    console.log(response)
    console.log(item)
    console.log(type)
    if (type === 'create' || type === 'update') {
        item.userLiked = Boolean(parseInt(response.body.data.attributes.likes));
        item.userRead = Boolean(parseInt(response.body.data.attributes.read));

        if (item.userLiked) {
            item.thumbsUps++;
        } else {
            item.thumbsUps--;
        }
    } else if (type === 'delete') {
        item.thumbsUps--;
    }
};
