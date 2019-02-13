<template>
    <div class="x5_student_view_container">
        <StudentList
            class="x5_student_list"
            v-for="list in studentLists"
            :list="list"
            v-bind:key="list.title"
            @likeItem="likeItem"
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
            DBX5ListsGet.setStudentListsFromDB(this, this.studentLists, data.recommendations);
        },
        data() {
            return {
                studentLists: DBX5ListsGet.setInitialCustomLists()
            };
        },
        methods: {
            likeItem(item) {
                const headers = {
                    'Content-Type': 'application/json'
                };

                if (item.userLiked) {
                    this.$http
                        .delete('http://localhost/studip-42/plugins.php/argonautsplugin/x5-user-items/' + item.id, {
                            headers
                        })
                        .then(response => {
                            item.thumbsUps--;
                            item.userLiked = false;
                        });
                } else {
                    this.$http
                        .post(
                            'http://localhost/studip-42/plugins.php/argonautsplugin/x5-user-items/create',
                            {
                                data: {
                                    type: 'x5-user-items',
                                    attributes: {
                                        likes: true
                                    },
                                    relationships: {
                                        'x5-item': {
                                            type: 'x5-items',
                                            id: item.id
                                        }
                                    }
                                }
                            },
                            { headers }
                        )
                        .then(response => {
                            if (response.ok) {
                                item.thumbsUps++;
                                item.userLiked = true;
                            }
                        });
                }
            }
        }
    };
</script>

<style lang="scss" scoped>
    .x5_student_view_container {
        display: grid;
        grid-column-gap: 10px;
        grid-template-columns: 70% 29%;
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

