<template>
  <div class="x5_student_view_container">
    <StudentList
      v-for="list in studentLists"
      :key="list.title"
      :list="list"
      class="x5_student_list"      
      @likeItem="likeItem"
    />
  </div>
</template>

<script>
    //import { data } from '../../../data';

    import StudentList from '../student-list/student-list-component.vue';

    import * as DBX5ListsGet from './db-methods/x5lists/x5lists_get';
    import * as DBX5ItemLike from './db-methods/x5items/x5item_like';

    import * as RecommendationsGet from './x5api/recommendations-get';

    export default {
        components: {
            StudentList
        },
        data() {
            return {
                studentLists: DBX5ListsGet.setInitialCustomLists()
            };
        },
        created() {
            RecommendationsGet.getX5RecommendationById('26886', this)
                .then((response) => {
                    console.log(response);
                });
            DBX5ListsGet.setStudentListsFromDB(this, this.studentLists, data.recommendations);
        },
        methods: {
            likeItem(item) {
                DBX5ItemLike.likeItem(item, this);
            }
        }
    };
</script>

<style lang="scss" scoped>
    @media (max-width: 1024px) { 
        .x5_student_view_container {
            grid-template-columns: 99% 0%;
        }
    } 

    @media (min-width: 1025px) { 
        .x5_student_view_container {
            grid-template-columns: 85% 14%;
        }
    } 

    @media (min-width: 1299px) { 
        .x5_student_view_container {
            grid-template-columns: 70% 29%;
        }
    } 
    
    .x5_student_view_container {
        display: grid;
        grid-column-gap: 10px;
    }

    .x5_student_list {
        grid-column: 1;
        width: 100%;

        border-bottom: solid 1px #1f3f70;
        border-left: solid 1px #1f3f70;
        border-right: solid 1px #1f3f70;

        margin-bottom: 1em;
    }
</style>

