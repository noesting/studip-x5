<template>
    <div class="x5_dozent_view_container">
        <RecommendationsListHeader
            class="c x5_list_header"
            @searchClicked="searchRecommendations"
            :filters="filters"
            @applyFilters="applyFilters"
        ></RecommendationsListHeader>
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
            :recommendations="processedRecommendations"
            class="x5_material_list"
            @recommendationsListClick="recommendationsListClick"
            @likeItem="likeItem"
        ></RecommendationsList>
        <CustomList
            :customListItems="customListItemlist"
            class="x5_custom_list"
            @customListItemClick="customListItemClick"
            @editItem="editItem"
            @likeItem="likeItem"
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
    import * as DBX5ItemLike from './db-methods/x5items/x5item_like';
    import * as DBX5ItemEdit from './db-methods/x5items/x5item_edit';
    import * as DBX5CourseGet from './db-methods/x5courses/x5course_get';

    import * as RecommendationsGet from './x5api/recommendations-get';
    import * as RecommendationsProcessor from './x5api/recommendations-processor';

    export default {
        components: {
            RecommendationsListHeader,
            CustomListHeader,
            RecommendationsList,
            CustomList
        },

        data() {
            return {
                recommendations: [],
                customLists: DBX5ListsGet.setInitialCustomLists(),
                currentCustomListIndex: 0,
                filters: {
                    checkedLangs: [],
                    checkedFormats: []
                },
                searchtext: '',
                courseMetadata: []
            };
        },

        computed: {
            customListItemlist() {
                if (this.customLists && this.customLists.length > 0) {
                    return this.customLists[this.currentCustomListIndex].list;
                }

                return null;
            },

            processedRecommendations() {
                this.recommendations = data.recommendations;

                return RecommendationsProcessor.processRecommendations(
                    this.recommendations,
                    this.customLists[this.currentCustomListIndex],
                    this.filters,
                    this.searchtext,
                    this
                );
            }
        },

        created() {
            DBX5CourseGet.getCourseMetadata(this).then((response) => {
                this.courseMetadata = response;
                RecommendationsGet.getX5Recommendations(this.courseMetadata, this);
            });
            DBX5ListsGet.setCustomListsFromDB(this.customLists, data.recommendations, this).then(() => {
                RecommendationsProcessor.prepareRecommendations();
            });
        },

        methods: {
            recommendationsListClick(itemId) {
                let exists = false;
                if (!this.customLists[this.currentCustomListIndex] || !this.customLists[this.currentCustomListIndex].list) {
                    return
                }
                for (let i = 0; i < this.customLists[this.currentCustomListIndex].list.length; i++) {
                    if (
                        this.customLists[this.currentCustomListIndex].list[i] &&
                        this.customLists[this.currentCustomListIndex].list[i].id === itemId
                    ) {
                        exists = true;
                    }
                }

                if (!exists) {
                    this.customLists[this.currentCustomListIndex].list.push(this.recommendations[itemId]);
                }

                this.recommendations.find(recommendation => recommendation.id === itemId).inList = true;

                DBX5LISTAddItems.addItemsToCustomList(this.customLists, this.currentCustomListIndex, this);
            },

            customListItemClick(itemId) {
                let itemIndex;
                for (let i = 0; i < this.customLists[this.currentCustomListIndex].list.length; i++) {
                    if (
                        this.customLists[this.currentCustomListIndex].list[i] &&
                        this.customLists[this.currentCustomListIndex].list[i].id === itemId
                    ) {
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

                RecommendationsProcessor.markRecommendationsAsAdded();
            },

            addNewCustomList(newList) {
                console.log('create new customList', newList);
                DBX5ListCreate.addNewList(this.customLists, newList, this);
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
                DBX5ListEdit.alterCustomList(this.customLists, this.currentCustomListIndex, this);
            },

            searchRecommendations(searchtext) {
                this.searchtext = searchtext;
            },

            applyFilters(filters) {
                this.filters = filters;
            },

            editItem(item) {
                DBX5ItemEdit.editItem(item, this, this.customLists, this.currentCustomListIndex);
            },

            likeItem(item) {
                DBX5ItemLike.likeItem(item, this);
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

