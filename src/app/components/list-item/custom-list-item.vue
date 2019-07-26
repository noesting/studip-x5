<template>
    <div class="x5_list_item_container">
        <div @click="openModal()">
            <ListItem v-bind:item="item" v-bind:key="item.id"></ListItem>
        </div>
        <!-- <div class="x5_list_item_comment" @click="action(item.id)">
            <h3>
                <StudipIcon v-bind:icon_name="'comment2'" v-bind:color="'blue'"></StudipIcon>
            </h3>
        </div>
        <div class="x5_list_item_star" @click="action(item.id)">
            <h3>
                <StudipIcon v-bind:icon_name="'star'" v-bind:color="'blue'"></StudipIcon>
            </h3>
        </div>-->
        <div class="x5_list_item_action" @click="action(item.id)">
            <h3>
                <StudipIcon v-bind:icon_name="'decline'" v-bind:color="'blue'"></StudipIcon>
            </h3>
        </div>
        <modal name="custom-list-item-detail">Hello</modal>
    </div>
</template>

<script>
    import * as DBX5ItemLike from '../containers/db-methods/x5items/x5item_like';
    import ListItem from './list-item-component.vue';
    import StudipIcon from '../studip-components/studip-clickable-icon-component';
    import CustomListItemDetailModal from '../modals/custom-list-item-detail-modal.vue';

    export default {
        props: ['item'],
        components: {
            ListItem,
            StudipIcon
        },
        data() {
            return {
                itemMarkedAsRead: this.item.markedAsRead
            }
        },
        methods: {
            action(id) {
                this.$emit('customListClickAction', id);
            },

            openModal() {
                const eventBus = new Vue();

                this.$modal.show(
                    CustomListItemDetailModal,
                    { item: this.item, eventBus: eventBus },
                    { height: 'auto', width: '70%' },
                    { 'before-close': this.detailModalClose }
                );

                this.makeItemAsRead(this.item);

                eventBus.$on('like', () => {
                    console.log('i like!');
                    this.$emit('likeItem', this.item);
                });
            },

            detailModalClose() {
                console.log('closed modal', this.item);
                this.$emit('editItem', this.item);
            },

            makeItemAsRead(item) {
                DBX5ItemLike.markItemAsRead(item, this);
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
        // grid-template-columns: 85% 5% 5% 5%;
        grid-template-columns: 95% 5%;
    }

    .x5_list_item_comment {
        text-align: center;
        grid-column: 2;

        cursor: pointer;
    }

    .x5_list_item_star {
        text-align: center;
        grid-column: 3;

        cursor: pointer;
    }

    .x5_list_item_action {
        text-align: center;
        // grid-column: 4;
        grid-column: 2;

        cursor: pointer;
    }
</style>

