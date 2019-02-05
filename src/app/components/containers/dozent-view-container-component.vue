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

    import * as DBX5ListsGet from './db-methods/x5lists/x5lists_get';
    import * as DBX5ListCreate from './db-methods/x5lists/x5lists_create';
    import * as DBX5ListEdit from './db-methods/x5lists/x5list_edit';
    import * as DBX5ListRemove from './db-methods/x5lists/x5lists_remove';
    import * as DBX5LISTAddItems from './db-methods/x5lists/x5lists_items_edit';

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
                customLists: DBX5ListsGet.setInitialCustomLists(),
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
            DBX5ListsGet.setCustomListsFromDB(this.customLists, this.recommendations, this);
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

                DBX5LISTAddItems.addItemsToCustomList(this.customLists, this.currentCustomListIndex, this);
            },

            customListItemClick(itemId) {
                let itemIndex;
                for (let i = 0; i < this.customLists[this.currentCustomListIndex].list.length; i++) {
                    if (this.customLists[this.currentCustomListIndex].list[i].id === itemId) {
                        itemIndex = i;
                    }
                }
                this.customLists[this.currentCustomListIndex].list.splice(itemIndex, 1);

                DBX5LISTAddItems.addItemsToCustomList(this.customLists, this.currentCustomListIndex, this);
            },

            setCurrentCustomListIndex(newIndex) {
                if (newIndex < 0) {
                    newIndex = 0;
                }

                this.currentCustomListIndex = newIndex;
            },

            addNewCustomList() {
                DBX5ListCreate.addNewList(this.customLists, this);
            },

            alterCustomList() {
                DBX5ListEdit.alterCustomList(this.customLists, this.currentCustomListIndex, this);
            },

            removeCurrentListItem() {
                const deleteListIndex = this.currentCustomListIndex;
                this.setCurrentCustomListIndex(--this.currentCustomListIndex);

                if (this.customLists.length === 1) {
                    addNewList(this.customLists, this);
                }

                DBX5ListRemove.removeListFromDB(this.customLists, deleteListIndex, this);
            },

            shareShareCurrentCustomList() {
                this.customLists[this.currentCustomListIndex].shared = !this.customLists[this.currentCustomListIndex]
                    .shared;
            }
        }
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

