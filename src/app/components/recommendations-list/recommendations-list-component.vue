<template>
  <div id="recommendations-list">
    <RecommendationsListItem
      v-for="item in recommendations"
      :key="item.id"
      :item="item"
      :dataProcessed="dataProcessed"
      @recListClickAction="recListClickAction"
      @likeItem="likeItem"
      @markItemAsRead="markItemAsRead"
    />
  </div>
</template>

<script>
    //import { data } from '../../../data';
    import RecommendationsListItem from '../list-item/recommendations-list-item.vue';

    export default {
        components: {
            RecommendationsListItem
        },
        props: ['recommendations', 'dataProcessed'],
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