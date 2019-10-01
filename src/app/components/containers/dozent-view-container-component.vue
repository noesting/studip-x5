<template>
  <div class="x5_dozent_view_container">
    <RecommendationsListHeader
      class="c x5_list_header"
      :filters="filters"
      @searchClicked="searchRecommendations"
      @applyFilters="applyFilters"
    />
    <CustomListHeader
      ref="customListHeader"
      :customLists="customLists"
      :currentCustomListIndex="currentCustomListIndex"
      @setCurrentCustomListIndex="setCurrentCustomListIndex"
      @addNewList="addNewCustomList"
      @alterList="alterCustomList"
      @removeCurrentListItem="removeCurrentListItem"
      @shareListToggle="shareShareCurrentCustomList"
    />
    <PageChooser 
        :max-page="maxPage"
        :current-page="currentPage"
        @page-up="pageUp"
        @page-down="pageDown"
    />
    <PageChooser 
        :max-page="1"
        :current-page="1"
        @page-up="pageUp"
        @page-down="pageDown"
    />
    <RecommendationsList
      :recommendations="processedRecommendations"
      class="x5_material_list"
      @recommendationsListClick="recommendationsListClick"
      @likeItem="likeItem"
      @markItemAsRead="markItemAsRead"
    />
    <CustomList
      :customListItems="customListItemlist"
      class="x5_custom_list"
      @customListItemClick="customListItemClick"
      @editItem="editItem"
      @likeItem="likeItem"
      @markItemAsRead="markItemAsRead"
    />
    <cookie-consent>
      <template slot="message">
        This site uses the X5GON (EU project) recommendation service to provide personalized Open Educational Ressources. 
        <a 
          class="btn btn-link" 
          href="https://platform.x5gon.org/privacy_policy"
          target="_blank"
        >More information</a>
      </template>
      <template slot="button">
        <button class="btn btn-info">
          Accept
        </button>
      </template>
    </cookie-consent>
  </div>
</template>

<script>
    import RecommendationsListHeader from '../recommendations-list-header/recommendations-list-header-component.vue';
    import CustomListHeader from '../custom-list-header/custom-list-header-component.vue';
    import RecommendationsList from '../recommendations-list/recommendations-list-component.vue';
    import CustomList from '../custom-list/custom-list.component.vue';
    import PageChooser from '../studip-components/studip-pagechooser-component';

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
    import * as X5API from './x5api/x5api-config';

    export default {
        components: {
            RecommendationsListHeader,
            CustomListHeader,
            RecommendationsList,
            CustomList,
            PageChooser
        },

        data() {
            return {
                recommendations: [],
                recommendationsVault: [],
                customLists: DBX5ListsGet.setInitialCustomLists(),
                currentCustomListIndex: 0,
                filters: {
                    checkedLangs: [],
                    checkedFormats: []
                },
                searchtext: '',
                courseMetadata: [],
                cookieConsent: this.checkForCookieConsent(),
                currentPage: 1,
                maxPage: 1
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
            DBX5CourseGet.getCourseMetadata(this)
            .then(response => {
                this.courseMetadata = this.bundleCourseMetadata(response);
                return RecommendationsGet.getX5RecommendationsByText(this.courseMetadata, this.currentPage, this);
            })
            .then(recMaterial => {
                this.setRecommendations(recMaterial, 1);
                return DBX5ListsGet.setCustomListsFromDB(this.customLists, this.recommendations, this);
            })
            .then(() => {
                RecommendationsProcessor.prepareRecommendations();
            })
            .catch(error => console.log(error));
        },

        updated() {
            this.updateDummyItemsFromApi();
        },

        methods: {
            recommendationsListClick(itemId) {
                if (!this.customLists[this.currentCustomListIndex] || !this.customLists[this.currentCustomListIndex].list) {
                    return;
                }

                if (!this.checkItemInList(itemId)) {
                    this.recommendations.find(recommendation => recommendation.id === itemId).inList = true;
                    this.customLists[this.currentCustomListIndex].list.push(this.recommendations.find(recommendation => recommendation.id === itemId));
                    DBX5LISTAddItems.addItemsToCustomList(this.customLists, this.currentCustomListIndex, this);
                }
            },

            checkItemInList(itemId) {
                let exists = false;
                for (let i = 0; i < this.customLists[this.currentCustomListIndex].list.length; i++) {
                    if (
                        this.customLists[this.currentCustomListIndex].list[i] &&
                        this.customLists[this.currentCustomListIndex].list[i].id === itemId
                    ) {
                        exists = true;
                    }
                }
                return exists;
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
                let searchParam = this.searchtext === '' ? this.courseMetadata : this.searchtext;
                
                RecommendationsGet.getX5RecommendationsByText(searchParam, 1, this)
                .then((recMaterial) => {
                    this.currentPage = 1;
                    this.setRecommendations(recMaterial, 1);
                })
                .catch((error) => console.log(error)); 
            },

            setRecommendations(recMaterial, page) {
                this.recommendations = recMaterial;
                this.recommendationsVault[page] = this.recommendations;
                this.setTotalPageCount();
            },

            prefetchRecommendations(searchParam) {
                let maxPrefetchIndex = this.getMaxPrefetchIndex();

                if (this.currentPage <= this.maxPage) {
                    for (let i = this.currentPage; i <= maxPrefetchIndex; i++) {
                        RecommendationsGet.getX5RecommendationsByText(searchParam, i, this)
                        .then(recMaterial => {
                            this.setRecommendations(recMaterial, i);
                        });
                    }
                }
            },

            getMaxPrefetchIndex() {
                let maxPrefetchIndex = this.currentPage + X5API.PREFETCH_RANGE;

                return maxPrefetchIndex > this.maxPage ? this.maxPage : maxPrefetchIndex;
            },

            bundleCourseMetadata(courseMetadata) {
            //let keysToInclude = ['title', 'subtitle', 'description'];
            let keysToInclude = ['title', 'subtitle'];
            var textParameter = '';

            keysToInclude.forEach((key) => {
                if (courseMetadata[key] !== null || undefined || '')
                textParameter += courseMetadata[key] + ' ';
            });

            return textParameter.replace(/\s?$/, '');
            },
 
            applyFilters(filters) {
                this.filters = filters;
            },

            editItem(item) {
                DBX5ItemEdit.editItem(item, this, this.customLists, this.currentCustomListIndex);
            },

            likeItem(item) {
                DBX5ItemLike.likeItem(item, this);
                if (this.recommendations.find(recommendation => recommendation.id === item.id)) {
                    this.recommendations.find(recommendation => recommendation.id === item.id).userLiked = !this.recommendations.find(recommendation => recommendation.id === item.id).userLiked;
                }
                this.updateLikeInCustomLists(item.id);
            },

            markItemAsRead(item) {
                DBX5ItemLike.markItemAsRead(item, this);
                if (this.recommendations.find(recommendation => recommendation.id === item.id)) {
                    this.recommendations.find(recommendation => recommendation.id === item.id).userRead = true;
                }
                this.updateReadInCustomLists(item.id);
            },

            updateReadInCustomLists(itemId) {
                for (let i = 0; i < this.customLists.length; i++) {
                    for (let k = 0; k < this.customLists[i].list.length; k++) {
                        if (this.customLists[i].list[k].id === itemId) {
                            this.customLists[i].list[k].userRead = true;
                        }
                    };
                };
            },

            updateLikeInCustomLists(itemId) {
                for (let i = 0; i < this.customLists.length; i++) {
                    for (let k = 0; k < this.customLists[i].list.length; k++) {
                        if (this.customLists[i].list[k].id === itemId) {
                            this.customLists[i].list[k].userLiked = !this.customLists[i].list[k].userLiked;
                        }
                    };
                };
            },

            updateDummyItemsFromApi() {
                for (let i = 0; i < this.customLists.length; i++) {
                    if (!this.customLists[i].list) {
                        return;
                    } else {
                        for (let k = 0; k < this.customLists[i].list.length; k++) {
                            if (this.customLists[i].list[k].dummy) {
                                this.updateItemContentFromApi(this.customLists[i].list[k].id, i, k); 
                            }
                        };
                    } 
                };
            },

            updateItemContentFromApi(itemId, i, k) {
                RecommendationsGet.getX5RecommendationById(itemId, this)
                .then(response => {
                    this.customLists[i].list[k].title = response.title;
                    this.customLists[i].list[k].description = response.description;
                    this.customLists[i].list[k].language = response.language;
                    this.customLists[i].list[k].provider = response.provider.provider_name;
                    this.customLists[i].list[k].type = response.type;
                    this.customLists[i].list[k].url = response.url;
                    this.customLists[i].list[k].extension = response.extension;
                    this.customLists[i].list[k].license = response.license;
                    Reflect.deleteProperty(this.customLists[i].list[k], 'dummy');
                });
            },

            checkForCookieConsent() {
              if (document.cookie.split(';').filter((item) => item.trim().startsWith('cookieconsent_status')).length){
                return true;
              } else {
                return false;
              }
            },

            setTotalPageCount() {
                this.maxPage = this.recommendations.meta.total_pages;
            },

            pageUp(event) {
                let searchParam = this.searchtext === '' ? this.courseMetadata : this.searchtext;
                if (this.currentPage < this.maxPage) {
                    this.currentPage++;
                    this.recommendationsVault[this.currentPage] = this.recommendations;
                    RecommendationsGet.getX5RecommendationsByText(searchParam, this.currentPage, this)
                    .then(recMaterial => {
                        this.setRecommendations(recMaterial, 1);
                    });
                    this.prefetchRecommendations(searchParam);
                }
            },

            pageDown(event) {
                let searchParam = this.searchtext === '' ? this.courseMetadata : this.searchtext;
                if (this.currentPage > 1) {
                    this.currentPage--;
                    this.recommendationsVault[this.currentPage] = this.recommendations;
                    RecommendationsGet.getX5RecommendationsByText(searchParam, this.currentPage, this)
                    .then(recMaterial => {
                        this.setRecommendations(recMaterial, 1);
                    });
                }
            }
        }
    };
</script>

<style lang="scss" scoped>
@import "./node_modules/vue-cookieconsent-component/src/scss/cookie-consent";
@import "./node_modules/vue-cookieconsent-component/src/scss/cookie-consent-bottom";
@import "./node_modules/vue-cookieconsent-component/src/scss/cookie-consent-transition";

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

