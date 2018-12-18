<template>
    <div class="x5_list_item_inner" @click="openModal">
        <div class="x5_list_item_thumbnail"></div>
        <div class="x5_list_item_title">{{ item.title }}</div>
        <div
            class="x5_list_item_subtitle"
        >({{ item.thumbsUps }}) - {{ item.publishingYear }}: {{ item.author }}</div>
    </div>
</template>

<script>
    import ItemDetailModal from '../modals/item-detail-modal.vue';
    export default {
        props: ['item'],
        methods: {
            openModal() {
                console.log('trying to open modal');
                this.$modal.show(ItemDetailModal, { item: this.item }, { height: 'auto' });
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
        background-color: #e7ebf1;

        display: grid;
        grid-template-columns: 20% 80%;
        grid-template-rows: 70% 30%;

        cursor: pointer;
    }

    .x5_list_item_thumbnail {
        grid-column: 1;
        grid-row: 1/2;
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
</style>

