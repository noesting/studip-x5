<template>
    <div class="x5_dozent_view_container">
        <!-- <RecommendationsListHeader class="c x5_list_header"></RecommendationsListHeader> -->
        <RecommendationsListHeader class="c x5_list_header"></RecommendationsListHeader>
        <CustomListHeader></CustomListHeader>
        <RecommendationsList
            :recommendations="recommendations"
            class="x5_material_list"
            @recommendationsListClick="recommendationsListClick"
        ></RecommendationsList>
        <CustomList
            :customListItems="customListItems"
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
                customListItems: []
            };
        },
        methods: {
            recommendationsListClick(itemId) {
                this.customListItems.push(this.recommendations[itemId]);
            },

            customListItemClick(itemId) {
                let itemIndex;
                for (let i = 0; i < this.customListItems.length; i++) {
                    if (this.customListItems[i].id === itemId) {
                        itemIndex = i;
                    }
                }
                this.customListItems.splice(itemIndex, 1);
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

