<template>
    <div class="x5_list_item_inner" @click="openModal">
        <div class="x5_list_item_thumbnail">
            <StudipIcon
                class="x5-thumbnail-icon"
                v-bind:icon_name="'file-' + item.type"
                v-bind:color="'blue'"
            ></StudipIcon>
        </div>
        <div class="x5_list_item_title">{{ item.title }}</div>
        <div class="x5_list_item_subtitle">
            <StudipIcon v-bind:icon_name="'smiley'" v-bind:color="'black'"></StudipIcon>
            ({{ item.thumbsUps }}) - {{ item.publishingYear }}: {{ item.author }}
        </div>
    </div>
</template>

<script>
    import ItemDetailModal from '../modals/item-detail-modal.vue';
    import StudipIcon from '../studip-components/studip-icon-button-component.vue';

    export default {
        props: ['item'],
        components: {
            StudipIcon
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

    .x5-thumbnail-icon {
        margin-top: 0.5em;

        height: 2em;
        width: 2em;
    }
</style>

