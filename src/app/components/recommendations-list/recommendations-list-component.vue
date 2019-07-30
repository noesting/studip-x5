<template>
    <div id="recommendations-list">
        <RecommendationsListItem
            v-for="item in recommendations"
            v-bind:item="item"
            v-bind:key="item.id"
            @recListClickAction="recListClickAction"
            @likeItem="likeItem"
            @markItemAsRead="markItemAsRead"
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
            },

            likeItem(item) {
                this.$emit('likeItem', item);
            },

            markItemAsRead(item) {
                this.$emit('markItemAsRead', item)
            }
        }
    };
</script>