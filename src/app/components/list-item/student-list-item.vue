<template>
    <!-- <div class="x5_list_item_inner" @click="openModal"> -->
    <div class="x5_list_item_inner" @click="openModal()">
        <div class="x5_list_item_thumbnail">
            <StudipIcon class="thumbnail-icon" v-bind:icon_name="iconName" v-bind:color="'blue'"></StudipIcon>
        </div>
        <div class="x5_list_item_title">{{ item.title }}</div>
        <div class="x5_list_item_subtitle">
            <StudipIcon v-bind:icon_name="'star'" v-bind:color="'blue'"></StudipIcon>
            ({{ item.thumbsUps }}) - {{ item.publishingYear }}: {{ item.author }}
        </div>
    </div>
</template>

<script>
    import ItemDetailModal from '../modals/item-detail-modal.vue';
    import StudipIcon from '../studip-components/studip-icon-button-component.vue';

    import StudentListItemDetailModal from '../modals/student-list-item-detail-modal.vue';

    export default {
        props: ['item'],
        components: {
            StudipIcon,
            StudentListItemDetailModal
        },
        methods: {
            openModal() {
                const eventBus = new Vue();

                this.$modal.show(
                    StudentListItemDetailModal,
                    { item: this.item, eventBus: eventBus },
                    { height: 'auto', width: '70%' }
                );

                eventBus.$on('like', () => {
                    console.log('i like!');
                    this.$emit('likeItem', this.item);
                });
            }
        },
        computed: {
            iconName() {
                switch (this.item.type) {
                    case 'text':
                        return 'file-text';
                    case 'audio':
                        return 'file-audio';
                    case 'video':
                        return 'file-video';
                    case 'image':
                        return 'file-pic';
                    default:
                        return 'file';
                }
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

