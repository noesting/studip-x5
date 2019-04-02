<template>
    <!-- <div class="x5_list_item_inner" @click="openModal"> -->
    <div class="x5_list_item_inner">
        <div class="x5_list_item_thumbnail">
            <StudipIcon class="thumbnail-icon" v-bind:icon_name="iconName" v-bind:color="iconColor"></StudipIcon>
        </div>
        <div class="x5_list_item_title">{{ item.title }}</div>
        <div class="x5_list_item_subtitle">
            <StudipIcon v-bind:icon_name="'thumbs_up'" v-bind:color="iconColor"></StudipIcon>
            ({{ item.thumbsUps }}) - {{ item.publishingYear }}: {{ item.author }}
        </div>
    </div>
</template>

<script>
    import ItemDetailModal from '../modals/item-detail-modal.vue';
    import StudipIcon from '../studip-components/studip-clickable-icon-component';

    import * as IconHelper from './icon-helpers';

    export default {
        props: ['item', 'iconColor'],
        components: {
            StudipIcon
        },
        methods: {
            openModal() {
                this.$modal.show(ItemDetailModal, { item: this.item }, { height: 'auto', width: '70%' });
            }
        },
        computed: {
            iconName() {
                return IconHelper.getItemTypeIconName(this.item);
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

