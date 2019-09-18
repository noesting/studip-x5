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
    import StudentList from '../student-list/student-list-component.vue';

    import * as DBX5ListsGet from './db-methods/x5lists/x5lists_get';
    import * as DBX5ItemLike from './db-methods/x5items/x5item_like';
    import * as DBX5CourseGet from './db-methods/x5courses/x5course_get';

    import * as RecommendationsGet from './x5api/recommendations-get';

    export default {
        components: {
            StudentList
        },
        data() {
            return {
                studentLists: DBX5ListsGet.setInitialCustomLists(),
                recommendations: [],
                courseMetadata: [],
                requestResolved: false
            };
        },
        created() {
            DBX5CourseGet.getCourseMetadata(this)
            .then(response => {
                this.courseMetadata = response;
                return RecommendationsGet.getX5RecommendationsByCourse(this.courseMetadata, this);
            })
            .then(recMaterial => {
                this.recommendations = recMaterial;
                return DBX5ListsGet.setStudentListsFromDB(this.studentLists, this.recommendations, this);
            })
            .then(() => {
                this.updateItemsFromApi();
            })
            .catch(error => console.log(error));
        },
        updated() {
            this.updateItemsFromApi();
        },
        methods: {
            likeItem(item) {
                DBX5ItemLike.likeItem(item, this);
            },
            updateItemsFromApi() {
                for (let i = 0; i < this.studentLists.length; i++) {
                    if (!this.studentLists[i].list) {
                        return;
                    } else {
                        for (let k = 0; k < this.studentLists[i].list.length; k++) {
                            if (this.studentLists[i].list[k].dummy) {
                                this.updateItemContentFromApi(this.studentLists[i].list[k].id, i, k);
                            }
                        };
                    }; 
                } 
            },
            updateItemContentFromApi(itemId, i, k) {
                RecommendationsGet.getX5RecommendationById(itemId, this)
                .then(response => {
                    this.studentLists[i].list[k].title = response.title;
                    this.studentLists[i].list[k].description = response.description;
                    this.studentLists[i].list[k].language = response.language;
                    this.studentLists[i].list[k].provider = response.provider.provider_name;
                    this.studentLists[i].list[k].type = response.type;
                    this.studentLists[i].list[k].url = response.url;
                    this.studentLists[i].list[k].extension = response.extension;
                    this.studentLists[i].list[k].license = response.license;
                    Reflect.deleteProperty(this.studentLists[i].list[k], 'dummy');
                });
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

