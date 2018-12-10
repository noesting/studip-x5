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
    </div>
</template>

<script>
    import { data } from '../../../data';

    import RecommendationsListHeader from '../recommendations-list-header/recommendations-list-header-component.vue';
    import CustomListHeader from '../custom-list-header/custom-list-header-component.vue';
    import RecommendationsList from '../recommendations-list/recommendations-list-component.vue';

    export default {
        components: {
            RecommendationsListHeader,
            CustomListHeader,
            RecommendationsList
        },
        data() {
            return {
                recommendations: data.recommendations
            };
        },
        methods: {
            recommendationsListClick(itemId) {
                console.log('moving item', itemId, 'to customList');
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

    .c {
        grid-column: 1;
        grid-row: 1;
    }
</style>

