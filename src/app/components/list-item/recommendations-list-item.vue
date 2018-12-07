<template>
    <div class="x5_list_item_container">
        <ListItem v-bind:item="item" v-bind:key="item.id"></ListItem>
        <div
            class="x5_list_item_action"
            name="recommendations_actionButton"
            @click="action(item.id)"
        >
            <!-- <h3>
                <img
                    class="icon-role-clickable icon-shape-arr_1right"
                    src="http://localhost/studip-42/assets/images/icons/blue/arr_1right.svg"
                >
            </h3>-->
            <h3>
                <StudipIcon v-bind:icon_name="'arr_1right'" v-bind:color="'blue'"></StudipIcon>
            </h3>
        </div>
    </div>
</template>

<script>
    import ListItem from './list-item-component.vue';
    import StudipIcon from '../studip-components/studip-icon-button-component.vue';

    export default {
        props: ['item'],
        components: {
            ListItem,
            StudipIcon
        },
        methods: {
            action(id) {
                console.log('item id', id, 'clicked');
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

