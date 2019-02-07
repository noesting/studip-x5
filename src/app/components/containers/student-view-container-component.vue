<template>
    <div class="x5_student_view_container">
        <StudentList
            v-for="list in studentLists"
            :list="list"
            v-bind:key="list.title"
            class="x5_custom_list"
        ></StudentList>
    </div>
</template>

<script>
    import { data } from '../../../data';

    import StudentList from '../student-list/student-list-component.vue';

    import * as DBX5ListsGet from './db-methods/x5lists/x5lists_get';

    export default {
        components: {
            StudentList
        },
        created() {
            // DBX5ListsGet.setCustomListsFromDB(this.customLists, this.recommendations, this);
            console.log('setting lists here');
            DBX5ListsGet.setStudentListsFromDB(this, this.studentLists, data.recommendations);
        },
        data() {
            return {
                studentLists: DBX5ListsGet.setInitialCustomLists()
            };
        },
        methods: {}
    };

    const getStudentListsFromData = () => {
        return data.customLists.filter(listObject => listObject.shared);
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

