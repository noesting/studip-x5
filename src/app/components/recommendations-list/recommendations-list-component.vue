<template>
    <div id="recommendations-list">
        <RecommendationsListItem
            v-for="item in recommendations"
            v-bind:item="item"
            v-bind:key="item.id"
        ></RecommendationsListItem>
    </div>
</template>

<script>
    import { data } from '../../../data';
    import RecommendationsListItem from '../list-item/recommendations-list-item.vue';

    export default {
        components: {
            RecommendationsListItem
        },
        props: ['recommendations']
    };
</script>