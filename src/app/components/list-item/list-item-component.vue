<template>
  <!-- <div class="x5_list_item_inner" @click="openModal"> -->
  <div class="x5_list_item_inner">
    <div class="x5_list_item_thumbnail">
      <StudipIcon 
        class="thumbnail-icon" 
        :icon_name="iconName" 
        :color="iconColor"
      />
    </div>
    <div class="x5_list_item_title">{{ item.title }}</div>
    <div class="x5_list_item_subtitle">
      <StudipIcon 
        :icon_name="'thumbs_up'" 
        :color="iconColor"
        :dataProcessed="dataProcessed"
      />
      ({{ item.thumbsUps }}) - {{ dataProcessed }} {{ item.language }}: {{ item.provider }}
    </div>
  </div>
</template>

<script>
    import ItemDetailModal from '../modals/item-detail-modal.vue';
    import StudipIcon from '../studip-components/studip-clickable-icon-component';

    import * as IconHelper from './icon-helpers';

    export default {
        components: {
            StudipIcon
        },
        props: {
            item: {
                type: Object,
                required: true
            }, 
            iconColor: {
                type: String,
                default: 'grey'
            }, 
            dataProcessed: {
                type: Number,
                default: 0
            }
        },
        computed: {
            iconName() {
                return IconHelper.getItemTypeIconName(this.item);
            }
        },
        methods: {
            openModal() {
                this.$modal.show(ItemDetailModal, { item: this.item }, { height: 'auto', width: '70%' });
            }
        }
    };
</script>

<style lang="scss" scoped>
    .x5_list_item_inner {
        width: 100%;
        height: 4.5em;
        text-overflow: ellipsis;
        overflow: hidden;

        display: grid;
        grid-template-columns: 20% 80%;
        grid-template-rows: 66% 33%;

        cursor: pointer;
    }

    .x5_list_item_thumbnail {
        grid-column: 1;
        grid-row: 1/2;

        text-align: center;
    }

    .x5_list_item_title {
        grid-column: 2;
        grid-row: 1;

        overflow: hidden;
    }

    .x5_list_item_subtitle {
        grid-column: 2;
        grid-row: 2;

        overflow: hidden;
    }

    .thumbnail-icon {
        width: 2em;
        height: 2em;

        margin-top: 1em;
    }
</style>

