import * as Connection from '../general';

export const addNewList = (customLists, dozentViewContainer) => {
    const listObject = getNewListObjectForCustomLists(customLists);
    const json = getJsonApiFormatFromList(listObject);
    addListToDatabase(json, dozentViewContainer).then(response => {
        if (response.ok) {
            listObject.id = response.body.data.id;
            addNewListToArray(listObject, customLists, dozentViewContainer);
        }
    });
};

const getNewListObjectForCustomLists = customLists => {
    const newListObject = {
        title: getNewListTitle(customLists),
        list: []
    };

    return newListObject;
};

const getNewListTitle = customLists => {
    let title = 'Neue Liste';
    let index = 1;
    while (titleExistsInList(title, customLists)) {
        title = 'Neue Liste ' + index;
        index++;
    }

    return title;
};

const titleExistsInList = (title, list) => {
    for (let i = 0; i < list.length; i++) {
        if (list[i].title === title) {
            return true;
        }
    }

    return false;
};

const getJsonApiFormatFromList = newListItem => {
    const currentUrl = window.location.href;
    const rangeId = currentUrl.split('?cid=')[1];

    return {
        data: {
            type: 'x5-lists',
            attributes: {
                title: newListItem.title
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

const addListToDatabase = (newListJson, dozentViewContainer) => {
    const headers = Connection.getHeaders();

    return dozentViewContainer.$http.post(Connection.REST_ENDPOINT + 'list/add', newListJson, { headers });
};

const addNewListToArray = (listObject, customLists, dozentViewContainer) => {
    customLists.push(listObject);
    dozentViewContainer.setCurrentCustomListIndex(customLists.length - 1);
    dozentViewContainer.$refs.customListHeader.renameListClick();
};
