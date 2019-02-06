import * as Connection from '../general';

export const removeListFromDB = (customLists, deleteListIndex, dozentViewContainer) => {
    const idToDelete = customLists[deleteListIndex].id;

    dozentViewContainer.$http.delete(Connection.REST_ENDPOINT + 'x5-lists/' + idToDelete + '/delete').then(response => {
        if (response.ok) {
            customLists.splice(deleteListIndex, 1);
        }
    });
};
