<template>
    <div id="recommendations-list">
        <CustomListItem
            v-for="item in customListItems"
            v-bind:item="item"
            v-bind:key="item.id"
            @customListClickAction="customListClickAction"
            @editItem="editItem"
        ></CustomListItem>
    </div>
</template>

<script>
    import { data } from '../../../data';
    import CustomListItem from '../list-item/custom-list-item';

    export default {
        components: {
            CustomListItem
        },
        props: ['customListItems'],
        methods: {
            customListClickAction(itemId) {
                this.$emit('customListItemClick', itemId);
            },

            editItem(item) {
                this.$emit('editItem', item);
            }
        }
    };
</script>