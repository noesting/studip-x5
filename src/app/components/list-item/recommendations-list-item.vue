<template>
  <div :class="[item.inList ? 'x5_list_item_container_in_list' : 'x5_list_item_container']">
    <div @click="openModal()">
      <div :class="{ x5_item_unread: !checkIfReadOrInList() }" />
      <ListItem 
        :key="item.id"
        :item="item"
        :iconColor="iconColor"
        :dataProcessed="dataProcessed"
      />
    </div>
    <div
      class="x5_list_item_action"
      name="recommendations_actionButton"
      @click="action(item.id)"
    >
      <h3>
        <StudipIcon 
          :icon_name="'arr_1right'" 
          :color="iconColor"
        />
      </h3>
    </div>
  </div>
</template>

<script>
    import * as DBX5ItemLike from '../containers/db-methods/x5items/x5item_like';
    import ListItem from './list-item-component.vue';
    import StudipIcon from '../studip-components/studip-clickable-icon-component';

    import RecommendationsListItemDetailModal from '../modals/recommendation-list-item-detail-modal';

    export default {
        components: {
            ListItem,
            StudipIcon
        },
        props: ['item', 'dataProcessed'],
        computed: {
            iconColor() {
                if (this.item.inList) {
                    return 'grey';
                } else {
                    return 'blue';
                }
            }
        },
        methods: {
            action(id) {
                this.$emit('recListClickAction', id);
            },

            openModal() {
                const eventBus = new Vue();

                this.$modal.show(
                    RecommendationsListItemDetailModal,
                    { item: this.item, eventBus },
                    { height: 'auto', width: '70%' }
                );

                this.markItemAsRead();

                eventBus.$on('like', () => {
                    this.$emit('likeItem', this.item);
                });
            },

            markItemAsRead() {
                this.$forceUpdate();
                this.$emit('markItemAsRead', this.item)
            },

            checkIfReadOrInList() {
                if (this.item.inList) {
                    return true;
                } else {
                    return this.item.userRead;
                }
            }
        }
    };
</script>

<style lang="scss" scoped>
    .x5_list_item_container {
        width: 99.9%;
        height: 4.5em;
        padding-bottom: 0.33rem;
        padding-top: 0.33rem;
        text-overflow: ellipsis;
        overflow: hidden;
        margin-top: 0.33em;
        background-color: #e7ebf1;

        display: grid;
        grid-template-columns: 95% 5%;
    }

    .x5_list_item_container_in_list {
        width: 99.9%;
        height: 4.5em;
        padding-bottom: 0.33rem;
        padding-top: 0.33rem;
        text-overflow: ellipsis;
        overflow: hidden;
        margin-top: 0.33em;
        background-color: #eeeeee;

        display: grid;
        grid-template-columns: 95% 5%;
        color: #999999;
    }

    .x5_list_item_action {
        text-align: center;
        grid-column: 2;

        cursor: pointer;
    }

    .x5_item_unread {
        position: absolute;
        padding-bottom: 0.66em;
        margin-top: -0.33em;
        background-color: #1f3f70;
        height: 4.5em;
        width: 4px;
        z-index: 10;
    }
</style>

