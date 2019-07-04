import * as Connection from '../general';

export const removeListFromDB = (customLists, deleteListIndex, dozentViewContainer) => {
    const idToDelete = customLists[deleteListIndex].id;
    const headers = Connection.getHeaders();

    dozentViewContainer.$http.delete(Connection.REST_ENDPOINT + 'x5-lists/' + idToDelete + '/delete', { headers }).then(response => {
        if (response.ok) {
            customLists.splice(deleteListIndex, 1);
        }
    });
};
