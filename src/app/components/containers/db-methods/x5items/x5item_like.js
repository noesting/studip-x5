import * as Connection from '../general';

export const likeItem = (item, vueComponent) => {
    checkIfUserItemExists(item, vueComponent, 'like');
};

export const markItemAsRead = (item, vueComponent) => {
    checkIfUserItemExists(item, vueComponent, 'read');
};

const checkIfUserItemExists = (item, vueComponent, colToUpdate) => {
    if (!item) {
        createUserItem(item, vueComponent);
    } else {
        console.log('colToUpdate: ' + colToUpdate)
        if (colToUpdate === 'like') {
            updateUserItem(item, vueComponent, 'like');
        } else if (colToUpdate === 'read') {
            updateUserItem(item, vueComponent, 'read');
        }
    }
};

const updateUserItem = (item, vueComponent, updateCol) => {
    vueComponent.$http
        .patch(Connection.REST_ENDPOINT + 'x5-user-items/' + item.id + "/update/" + updateCol, updateCol, {
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

const createUserItem = (item, vueComponent) => {
    vueComponent.$http
        .post(Connection.REST_ENDPOINT + 'x5-user-items/create', JSON.stringify(getUserItemJsonApiObject(item)), {
            headers: Connection.getHeaders()
        })
        .then(response => {
            handleResponse(response, item, 'create');
        });
};

const getUserItemJsonApiObject = item => {
    return {
        data: {
            type: 'x5-user-items',
            attributes: {
                likes: false,
                read: false
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

const handleResponse = (response, item, type) => {
    if (response.ok) {
        modifyItem(response, item, type);
    }
};

const modifyItem = (response, item, type) => {
    item.userLiked = Boolean(parseInt(response.body.data.attributes.likes));
    item.userRead = Boolean(parseInt(response.body.data.attributes.read));

    if (item.userLiked) {
        item.thumbsUps++;
    } else {
        item.thumbsUps--;
    }
};
