import * as Connection from '../general';

export const likeItem = (item, vueComponent) => {
    if (item.userLiked) {
        deleteUserItem(item, vueComponent);
    } else {
        createUserItem(item, vueComponent);
    }
};

const deleteUserItem = (item, vueComponent) => {
    vueComponent.$http
        .delete(Connection.REST_ENDPOINT + 'x5-user-items/' + item.id, {
            headers: Connection.getHeaders()
        })
        .then(response => {
            handleResponse(response, item, false);
        });
};

const createUserItem = (item, vueComponent) => {
    vueComponent.$http
        .post(Connection.REST_ENDPOINT + 'x5-user-items/create', JSON.stringify(getUserItemJsonApiObject(item)), {
            headers: Connection.getHeaders()
        })
        .then(response => {
            handleResponse(response, item, true);
        });
};

const getUserItemJsonApiObject = item => {
    return {
        data: {
            type: 'x5-user-items',
            attributes: {
                likes: true
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

const handleResponse = (response, item, create) => {
    if (response.ok) {
        modifyItem(item, create);
    }
};

const modifyItem = (item, create) => {
    if (create) {
        item.thumbsUps++;
        item.userLiked = true;
    } else {
        item.thumbsUps--;
        item.userLiked = false;
    }
};
