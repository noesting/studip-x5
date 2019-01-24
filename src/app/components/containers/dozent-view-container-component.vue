<template>
    <div class="x5_dozent_view_container">
        <RecommendationsListHeader class="c x5_list_header"></RecommendationsListHeader>
        <CustomListHeader
            ref="customListHeader"
            :customLists="customLists"
            :currentCustomListIndex="currentCustomListIndex"
            @setCurrentCustomListIndex="setCurrentCustomListIndex"
            @addNewList="addNewCustomList"
            @alterList="alterCustomList"
            @removeCurrentListItem="removeCurrentListItem"
            @shareListToggle="shareShareCurrentCustomList"
        ></CustomListHeader>
        <RecommendationsList
            :recommendations="recommendations"
            class="x5_material_list"
            @recommendationsListClick="recommendationsListClick"
        ></RecommendationsList>
        <CustomList
            :customListItems="customListItemlist"
            class="x5_custom_list"
            @customListItemClick="customListItemClick"
        ></CustomList>
    </div>
</template>

<script>
    import { data } from '../../../data';

    import RecommendationsListHeader from '../recommendations-list-header/recommendations-list-header-component.vue';
    import CustomListHeader from '../custom-list-header/custom-list-header-component.vue';
    import RecommendationsList from '../recommendations-list/recommendations-list-component.vue';
    import CustomList from '../custom-list/custom-list.component.vue';

    export default {
        components: {
            RecommendationsListHeader,
            CustomListHeader,
            RecommendationsList,
            CustomList
        },

        data() {
            return {
                recommendations: data.recommendations,
                customLists: setInitialCustomLists(),
                currentCustomListIndex: 0
            };
        },

        computed: {
            customListItemlist() {
                if (this.customLists && this.customLists.length > 0) {
                    return this.customLists[this.currentCustomListIndex].list;
                }

                return null;
            }
        },

        created() {
            console.log('customLists before', this.customLists);
            setCustomListsFromDB(this.customLists);
        },

        methods: {
            recommendationsListClick(itemId) {
                let exists = false;
                for (let i = 0; i < this.customLists[this.currentCustomListIndex].list.length; i++) {
                    if (this.customLists[this.currentCustomListIndex].list[i].id === itemId) {
                        exists = true;
                    }
                }

                if (!exists) {
                    this.customLists[this.currentCustomListIndex].list.push(this.recommendations[itemId]);
                }
            },

            customListItemClick(itemId) {
                let itemIndex;
                for (let i = 0; i < this.customLists[this.currentCustomListIndex].list.length; i++) {
                    if (this.customLists[this.currentCustomListIndex].list[i].id === itemId) {
                        itemIndex = i;
                    }
                }
                this.customLists[this.currentCustomListIndex].list.splice(itemIndex, 1);
            },

            setCurrentCustomListIndex(newIndex) {
                if (newIndex < 0) {
                    newIndex = 0;
                }

                this.currentCustomListIndex = newIndex;
            },

            addNewCustomList() {
                addNewList(this.customLists, this);
            },

            alterCustomList() {
                alterCustomList(this.customLists, this.currentCustomListIndex, this);
            },

            removeCurrentListItem() {
                const deleteListIndex = this.currentCustomListIndex;
                this.setCurrentCustomListIndex(--this.currentCustomListIndex);

                if (this.customLists.length === 1) {
                    this.customLists.push({ title: 'Neue Liste', list: [] });
                }

                this.customLists.splice(deleteListIndex, 1);
            },

            shareShareCurrentCustomList() {
                this.customLists[this.currentCustomListIndex].shared = !this.customLists[this.currentCustomListIndex]
                    .shared;
            }
        }
    };

    const setInitialCustomLists = () => {
        return [{}];
    };

    const setCustomListsFromDB = customLists => {
        const headers = getHeaders();
        const rangeId = getRangeId();

        return Vue.http
            .get('http://localhost/studip-42/plugins.php/argonautsplugin/x5lists/' + rangeId, { headers })
            .then(response => handleGetListsResponse(response, customLists));
    };

    const getRangeId = () => {
        const currentUrl = window.location.href;
        const rangeId = currentUrl.split('?cid=')[1];

        return rangeId;
    };

    const getHeaders = () => {
        const headers = {
            'Content-Type': 'application/json'
        };

        return headers;
    };

    const setCustomListsFromResponse = (response, customLists) => {
        customLists.shift();
        for (let i = 0; i < response.body.data.length; i++) {
            addListToArray(customLists, response.body.data[i].attributes);
        }
    };

    const addListToArray = (customLists, list) => {
        customLists.push({
            id,
            title,
            list: []
        });
    };

    const handleGetListsResponse = (response, customLists) => {
        if (response.ok) {
            setCustomListsFromResponse(response, customLists);
        }
    };

    const addNewList = (customLists, dozentViewContainer) => {
        const listObject = getNewListObjectForCustomLists(customLists);
        const json = getJsonApiFormatFromList(listObject);
        addListToDatabase(json).then(response => {
            if (response.ok) {
                console.log('response', response);
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

    const addListToDatabase = newListJson => {
        const headers = {
            'Content-Type': 'application/json'
        };

        return Vue.http.post('http://localhost/studip-42/plugins.php/argonautsplugin/list/add', newListJson, { headers });
    };

    const addNewListToArray = (listObject, customLists, dozentViewContainer) => {
        customLists.push(listObject);
        dozentViewContainer.setCurrentCustomListIndex(customLists.length - 1);
        dozentViewContainer.$refs.customListHeader.renameListClick();
    };

    const alterCustomList = (customLists, currentCustomListIndex, dozentViewContainer) => {
        const json = getJsonApiFormatForUpdate(customLists[currentCustomListIndex]);
        alterListInDatabase(json).then(response => {
            if (response.ok) {
                console.log('WOHOO update worked');
            }
        });
    };

    const getJsonApiFormatForUpdate = listItem => {
        const rangeId = getRangeId();

        return {
            data: {
                id: listItem.id,
                type: 'x5-lists',
                attributes: {
                    title: listItem.title,
                    visible: listItem.visible || false,
                    position: listItem.position || '0'
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

    const alterListInDatabase = alteredListJson => {
        const headers = {
            'Content-Type': 'application/json'
        };

        return Vue.http.patch(
            'http://localhost/studip-42/plugins.php/argonautsplugin/list/' + alteredListJson.data.id + '/alter',
            alteredListJson,
            { headers }
        );
    };
</script>

<style lang="scss" scoped>
    .x5_dozent_view_container {
        display: grid;
        grid-column-gap: 10px;
        grid-template-columns: 49% 49%;
    }

    .x5_list_header {
        width: 100%;
        height: 100%;

        display: flex;
        flex-direction: column;
        background-color: #e7ebf1;

        border: 1px solid #1f3f70;
    }

    .x5_material_list {
        width: 100%;

        border-bottom: solid 1px #1f3f70;
        border-left: solid 1px #1f3f70;
        border-right: solid 1px #1f3f70;

        grid-column: 1;
    }

    .x5_custom_list {
        width: 100%;

        border-bottom: solid 1px #1f3f70;
        border-left: solid 1px #1f3f70;
        border-right: solid 1px #1f3f70;
    }

    .c {
        grid-column: 1;
        grid-row: 1;
    }
</style>

