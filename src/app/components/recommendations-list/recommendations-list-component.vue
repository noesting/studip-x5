<template>
    <div id="recommendations-list">
        <RecommendationsListItem
            v-for="item in recommendations"
            v-bind:item="item"
            v-bind:key="item.id"
            @recListClickAction="recListClickAction"
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
        props: ['recommendations'],
        methods: {
            recListClickAction(itemId) {
                this.$emit('recommendationsListClick', itemId);
            }
        }
    };
</script>