import * as Connection from '../general';

export const editItem = (item, vueComponent, customLists, currentCustomListIndex) => {
    vueComponent.$http
        .patch(
            Connection.REST_ENDPOINT + 'x5-list-items/' + item.id + '/' + customLists[currentCustomListIndex].id,
            getJSONAPICommentObject(item),
            { headers: Connection.getHeaders() }
        )
        .then(response => handleResponse(response));
};

const getJSONAPICommentObject = item => {
    return {
        data: {
            type: 'x5-list-items',
            attributes: {
                comment: item.comment
            }
        }
    };
};

const handleResponse = response => {
    if (response.ok) {
        console.log('yippi');
    }
};
