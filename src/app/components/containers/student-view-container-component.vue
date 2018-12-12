<template>
    <div class="x5_student_view_container">
        <CustomList
            :customListItems="customListItemlist"
            class="x5_custom_list"
            @customListItemClick="customListItemClick"
        ></CustomList>
    </div>
</template>

<script>
    import { data } from '../../../data';

    import CustomList from '../custom-list/custom-list.component.vue';

    export default {
        components: {
            CustomList
        },
        data() {
            return {
                recommendations: data.recommendations,
                customLists: data.customLists,
                currentCustomListIndex: 0
            };
        },
        computed: {
            customListItemlist() {
                if (this.customLists && this.customLists.length > 0) {
                    return this.customLists[this.currentCustomListIndex].list;
                }

                return null;
            }
        },
        methods: {
            customListItemClick(itemId) {
                let itemIndex;
                for (let i = 0; i < this.customLists[this.currentCustomListIndex].list.length; i++) {
                    if (this.customLists[this.currentCustomListIndex].list[i].id === itemId) {
                        itemIndex = i;
                    }
                }
                this.customLists[this.currentCustomListIndex].list.splice(itemIndex, 1);
            }
        }
    };
</script>

<style lang="scss" scoped>
    .x5_student_view_container {
        display: grid;
        grid-column-gap: 10px;
        grid-template-columns: 49% 49%;
    }

    .x5_custom_list {
        width: 100%;

        border-bottom: solid 1px #1f3f70;
        border-left: solid 1px #1f3f70;
        border-right: solid 1px #1f3f70;
    }
</style>

