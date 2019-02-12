<template>
    <div>
        <div class="x5_headline">{{ list.title }}</div>
        <div class="x5_list_item" v-for="item in list.list" v-bind:key="item.id">
            <StudentListItem v-bind:item="item" @likeItem="likeItem"></StudentListItem>
        </div>
    </div>
</template>

<script>
    import ListItem from '../list-item/list-item-component';
    import StudentListItem from '../list-item/student-list-item.vue';

    export default {
        components: {
            ListItem,
            StudentListItem
        },
        props: ['list'],
        methods: {
            likeItem(item) {
                this.$emit('likeItem', item);
            }
        }
    };
</script>

<style lang="scss" scoped>
    .x5_headline {
        border: solid 1px #28497c;
        padding: 0.5em;
        margin: 0 -1px 0 -1px;

        font-weight: bold;
        font-size: 1.5em;

        color: #1f3f70;
        text-align: center;
        background-color: #e7ebf1;
    }

    .x5_list_item {
        width: 100%;
        height: 4.5em;
        text-overflow: ellipsis;
        overflow: hidden;
        margin-top: 1em;
        background-color: #e7ebf1;

        display: grid;
        grid-template-columns: 95% 5%;
    }
</style>
