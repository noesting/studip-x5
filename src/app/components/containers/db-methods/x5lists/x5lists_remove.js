import * as Connection from '../general';

export const removeListFromDB = (customLists, deleteListIndex, dozentViewContainer) => {
    const idToDelete = customLists[deleteListIndex].id;

    dozentViewContainer.$http.delete(Connection.REST_ENDPOINT + 'x5list/' + idToDelete + '/remove').then(response => {
        if (response.ok) {
            customLists.splice(deleteListIndex, 1);
        }
    });
};
