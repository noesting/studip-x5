import * as Connection from '../general';

export const likeItem = (item, vueComponent) => {
    checkIfUserItemExists(item, vueComponent);
};

const checkIfUserItemExists = (item, vueComponent) => {
    if (!item) {
        createUserItem(item, vueComponent);
    } else {
        updateUserItem(item, vueComponent, 'like');
        checkIfUserItemIsAlreadyLiked(item, vueComponent);
    }
};

const checkIfUserItemIsAlreadyLiked = (item, vueComponent) => {
    //console.log("checkIfUserItemIsAlreadyLiked")
    //console.log(item)
};

const updateUserItem = (item, vueComponent, updateCol) => {
    console.log(item)
    console.log(updateCol)
    vueComponent.$http
        .patch(Connection.REST_ENDPOINT + 'x5-user-items/' + item.id + "/update", updateCol, {
            headers: Connection.getHeaders()
        })
        .then(response => {
            console.log(response)
            //handleResponse(response, item, true);
        });
};

const deleteUserItem = (item, vueComponent) => {
    vueComponent.$http
        .delete(Connection.REST_ENDPOINT + 'x5-user-items/' + item.id, {
            headers: Connection.getHeaders()
        })
        .then(response => {
            console.log(response)
            handleResponse(response, item, false);
        });
};

const createUserItem = (item, vueComponent) => {
    vueComponent.$http
        .post(Connection.REST_ENDPOINT + 'x5-user-items/create', JSON.stringify(getUserItemJsonApiObject(item)), {
            headers: Connection.getHeaders()
        })
        .then(response => {
            console.log(response)
            handleResponse(response, item, true);
        });
};

const getUserItemJsonApiObject = item => {
    return {
        data: {
            type: 'x5-user-items',
            attributes: {
                likes: true,
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

const handleResponse = (response, item, create) => {
    if (response.ok) {
        modifyItemLikes(item, create);
    }
};

const modifyItemLikes = (item, create) => {
    if (create) {
        item.thumbsUps++;
        item.userLiked = true;
    } else {
        item.thumbsUps--;
        item.userLiked = false;
    }
};
