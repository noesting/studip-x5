import * as Connection from '../general';

export const addItemsToCustomList = (customLists, currentCustomListIndex, dozentViewContainer) => {
    const json = getJsonApiFormatForUpdate(customLists[currentCustomListIndex]);
    alterListInDatabase(json, dozentViewContainer).then(response => {
        if (response.ok) {
            console.log('yeah!!!');
        }
    });
};

const getJsonApiFormatForUpdate = listItem => {
    const itemRelationShips = getItemRelationships(listItem);

    return {
        data: {
            id: listItem.id,
            type: 'x5-lists',

            relationships: {
                x5items: itemRelationShips
            }
        }
    };
};

const getItemRelationships = listItem => {
    const itemRelationShips = [];

    for (let i = 0; i < listItem.list.length; i++) {
        itemRelationShips.push({
            type: 'x5-items',
            id: listItem.list[i].id
        });
    }

    return itemRelationShips;
};

const alterListInDatabase = (alteredListJson, dozentViewContainer) => {
    const headers = Connection.getHeaders();

    return dozentViewContainer.$http.post(
        Connection.REST_ENDPOINT + 'x5list/' + alteredListJson.data.id + '/items/add',
        alteredListJson,
        { headers }
    );
};
