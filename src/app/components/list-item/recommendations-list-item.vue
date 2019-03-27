<template>
    <div v-bind:class="[item.inList ? 'x5_list_item_container_in_list' : 'x5_list_item_container']">
        <div @click="openModal()">
            <ListItem v-bind:item="item" v-bind:iconColor="iconColor" v-bind:key="item.id"></ListItem>
        </div>
        <div
            class="x5_list_item_action"
            name="recommendations_actionButton"
            @click="action(item.id)"
        >
            <h3>
                <StudipIcon v-bind:icon_name="'arr_1right'" v-bind:color="iconColor"></StudipIcon>
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
        padding-bottom: 0.33rem;
        padding-top: 0.33rem;
        text-overflow: ellipsis;
        overflow: hidden;
        margin-top: 1em;
        background-color: #e7ebf1;

        display: grid;
        grid-template-columns: 95% 5%;
    }

    .x5_list_item_container_in_list {
        width: 100%;
        height: 4.5em;
        padding-bottom: 0.33rem;
        padding-top: 0.33rem;
        text-overflow: ellipsis;
        overflow: hidden;
        margin-top: 1em;
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
</style>

