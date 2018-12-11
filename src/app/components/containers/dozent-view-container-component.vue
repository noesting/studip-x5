<template>
    <div class="x5_dozent_view_container">
        <!-- <RecommendationsListHeader class="c x5_list_header"></RecommendationsListHeader> -->
        <RecommendationsListHeader class="c x5_list_header"></RecommendationsListHeader>
        <CustomListHeader
            ref="customListHeader"
            :customLists="customLists"
            :currentCustomListIndex="currentCustomListIndex"
            @setCurrentCustomListIndex="setCurrentCustomListIndex"
            @addNewList="addNewCustomList"
            @removeCurrentListItem="removeCurrentListItem"
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
                customLists: data.customLists,
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
                let newListItem = { title: 'Neue Liste', list: [] };
                // this.customLists.push({  });

                if (itemExistsInListByTitle(newListItem, this.customLists)) {
                    let i = 1;
                    let inserted = false;
                    while (!inserted || i > 100) {
                        newListItem.title = 'Neue Liste ' + i;
                        if (!itemExistsInListByTitle(newListItem, this.customLists)) {
                            this.customLists.push(newListItem);
                            inserted = true;
                        }
                        i++;
                    }
                } else {
                    this.customLists.push(newListItem);
                }

                this.setCurrentCustomListIndex(this.customLists.length - 1);
                this.$refs.customListHeader.renameListClick();
            },

            removeCurrentListItem() {
                const deleteListIndex = this.currentCustomListIndex;
                this.setCurrentCustomListIndex(--this.currentCustomListIndex);

                if (this.customLists.length === 1) {
                    this.customLists.push({ title: 'Neue Liste', list: [] });
                }

                this.customLists.splice(deleteListIndex, 1);
            }
        }
    };

    const itemExistsInListByTitle = (item, list) => {
        for (let i = 0; i < list.length; i++) {
            if (list[i].title === item.title) {
                return true;
            }
        }

        return false;
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

