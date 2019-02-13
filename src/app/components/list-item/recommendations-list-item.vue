<template>
    <div class="x5_list_item_container">
        <div @click="openModal()">
            <ListItem v-bind:item="item" v-bind:key="item.id"></ListItem>
        </div>
        <div
            class="x5_list_item_action"
            name="recommendations_actionButton"
            @click="action(item.id)"
        >
            <h3>
                <StudipIcon v-bind:icon_name="'arr_1right'" v-bind:color="'blue'"></StudipIcon>
            </h3>
        </div>
    </div>
</template>

<script>
    import ListItem from './list-item-component.vue';
    import StudipIcon from '../studip-components/studip-clickable-icon-component';

    import RecommendationsLiustItemDetailModal from '../modals/recommendation-list-item-detail-modal';

    export default {
        props: ['item'],
        components: {
            ListItem,
            StudipIcon
        },
        methods: {
            action(id) {
                this.$emit('recListClickAction', id);
            },

            openModal() {
                const eventBus = new Vue();

                this.$modal.show(
                    RecommendationsLiustItemDetailModal,
                    { item: this.item, eventBus: eventBus },
                    { height: 'auto', width: '70%' }
                );

                eventBus.$on('like', () => {
                    this.$emit('likeItem', this.item);
                });
            }
        }
    };
</script>

<style lang="scss" scoped>
    .x5_list_item_container {
        width: 100%;
        height: 4.5em;
        text-overflow: ellipsis;
        overflow: hidden;
        margin-top: 1em;
        background-color: #e7ebf1;

        display: grid;
        grid-template-columns: 95% 5%;
    }

    .x5_list_item_action {
        text-align: center;
        grid-column: 2;

        cursor: pointer;
    }
</style>

