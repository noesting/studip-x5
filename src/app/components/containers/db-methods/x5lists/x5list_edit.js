import * as Connection from '../general';

export const alterCustomList = (customLists, currentCustomListIndex, dozentViewContainer) => {
    const json = getJsonApiFormatForUpdate(customLists[currentCustomListIndex]);
    alterListInDatabase(json, dozentViewContainer).then(response => {
        if (response.ok) {
        }
    });
};

const getJsonApiFormatForUpdate = listItem => {
    const rangeId = Connection.getRangeId();

    return {
        data: {
            id: listItem.id,
            type: 'x5-lists',
            attributes: {
                title: listItem.title,
                visible: listItem.shared || false,
                position: listItem.position || '0',
                releaseDate: listItem.releaseDate.toISOString()
            },

            relationships: {
                course: {
                    type: 'courses',
                    id: rangeId
                }
            }
        }
    };
};

const alterListInDatabase = (alteredListJson, dozentViewContainer) => {
    const headers = Connection.getHeaders();

    return dozentViewContainer.$http.patch(
        Connection.REST_ENDPOINT + 'x5-lists/' + alteredListJson.data.id + '/update',
        alteredListJson,
        { headers }
    );
};
