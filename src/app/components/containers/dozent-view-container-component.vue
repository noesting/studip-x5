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
                searchtext: ''
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
                DBX5ListsGet.enrichRecommendations(this, this.recommendations);

                this.setRecommendationsBySearchText();
                this.setRecommendationsByFilters();

                return this.recommendations;
            }
        },

        created() {
            DBX5ListsGet.setCustomListsFromDB(this.customLists, data.recommendations, this);
            DBX5ListsGet.enrichRecommendations(this, this.recommendations);
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
                DBX5ListEdit.alterCustomList(this.customLists, this.currentCustomListIndex, this);
            },

            searchRecommendations(searchtext) {
                this.searchtext = searchtext;
            },

            applyFilters(filters) {
                this.filters = filters;
            },

            setRecommendationsBySearchText() {
                if (this.searchtext) {
                    this.recommendations = this.recommendations.filter(recommendation => {
                        const regexp = new RegExp(this.searchtext, 'i');
                        return recommendation.title.match(regexp);
                    });
                }
            },

            setRecommendationsByFilters() {
                if (this.filters.checkedLangs.length > 0 || this.filters.checkedFormats.length > 0) {
                    this.recommendations = this.recommendations.filter(recommendation => {
                        return (
                            this.recommendationFitsByLangAndFormat(recommendation) ||
                            this.recommendationFitsByLang(recommendation) ||
                            this.recommendationFitsByFormat(recommendation)
                        );
                    });
                }
            },

            recommendationFitsByLangAndFormat(recommendation) {
                return this.recommendationIsInLangs(recommendation) && this.recommendationIsInFormats(recommendation);
            },

            recommendationFitsByLang(recommendation) {
                return this.recommendationIsInLangs(recommendation) && this.filters.checkedFormats.length === 0;
            },

            recommendationFitsByFormat(recommendation) {
                return this.filters.checkedLangs.length === 0 && this.recommendationIsInFormats(recommendation);
            },

            recommendationIsInLangs(recommendation) {
                return this.filters.checkedLangs.indexOf(recommendation.language) > -1;
            },

            recommendationIsInFormats(recommendation) {
                return this.filters.checkedFormats.indexOf(recommendation.type) > -1;
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

