<template>
    <div class="d x5_list_header">
        <v-dialog/>
        <modal name="hello-world">Hello, world!</modal>
        <div class="x5_headline">Meine Listen</div>

        <div class="x5_button_line">
            <div class="x5_button_container">
                <div class="dropdown">
                    <StudipIconButton
                        class="x5_choose_list_button"
                        :text="'Liste auswählen'"
                        :icon="'arr_1down'"
                    ></StudipIconButton>
                    <div class="dropdown_content choose_list" id="choose_custom_list_select">
                        <div
                            v-for="list in customLists"
                            v-bind:key="list.title"
                            class="customListEntry"
                            @click="chooseList(list)"
                        >{{ list.title }}</div>
                    </div>
                </div>
            </div>

            <div class="x5_button_container">
                <StudipButton @studipbuttonClick="addList()" :text="'Neue Liste'"></StudipButton>
            </div>
        </div>

        <div class="x5_current_list">
            <input
                ref="listTitleRef"
                type="text"
                v-model="customLists[currentCustomListIndex].title"
                class="x5_current_list_text"
                id="x5_current_list_text"
                name="x5_current_list_text"
                :disabled="inputDisabled"
                @focusout="listTitleFocusOut"
            >
            <div class="dropdown">
                <div class="x5_item_action" name="x5_item_action">
                    <StudipIcon :icon_name="'action'" :color="'blue'"></StudipIcon>
                </div>
                <div class="dropdown_content options_menu">
                    <div
                        v-if="!customLists[currentCustomListIndex].shared"
                        class="editListButton"
                        name="editListButton"
                        id="shareListClick"
                        @click="toggleShareListClick"
                    >Für Studierende freigeben</div>
                    <div
                        v-if="customLists[currentCustomListIndex].shared"
                        class="editListButton"
                        name="editListButton"
                        id="unshareListClick"
                        @click="toggleShareListClick"
                    >Freigabe für Studierende entziehen</div>
                    <div
                        class="editListButton"
                        name="editListButton"
                        id="renameListClick"
                        @click="renameListClick"
                    >Umbenennen</div>
                    <div
                        class="editListButton"
                        name="editListButton"
                        id="deleteListClick"
                        @click="removeListClick"
                    >Löschen</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import StudipButton from '../studip-components/studip-button-component.vue';
    import StudipIcon from '../studip-components/studip-clickable-icon-component';
    import StudipIconButton from '../studip-components/studip-icon-button-component';

    import NewListAssitentModal from '../modals/new-list-assistent-modal.vue';

    import { data } from '../../../data';

    export default {
        components: {
            StudipButton,
            StudipIcon,
            StudipIconButton
        },
        props: ['customLists', 'currentCustomListIndex'],
        data() {
            return {
                listTitleDisabled: true
            };
        },
        computed: {
            inputDisabled() {
                return this.listTitleDisabled;
            }
        },
        methods: {
            chooseList(list) {
                for (let i = 0; i < this.customLists.length; i++) {
                    if (list.title === this.customLists[i].title) {
                        this.$emit('setCurrentCustomListIndex', i);
                    }
                }
            },

            renameListClick() {
                this.listTitleDisabled = false;
                this.$nextTick(() => {
                    this.$refs.listTitleRef.focus();
                });
            },

            removeListClick() {
                this.$modal.show('dialog', {
                    title: 'Löschen',
                    text: 'Liste unwiderruflich löschen?',
                    buttons: [
                        {
                            title: 'Löschen',
                            handler: () => {
                                this.$emit('removeCurrentListItem');
                                this.$modal.hide('dialog');
                            }
                        },
                        {
                            title: 'Abbrechen',
                            handler: () => this.$modal.hide('dialog'),
                            default: true
                        }
                    ]
                });
            },

            listTitleFocusOut() {
                this.listTitleDisabled = true;
                this.$emit('alterList');
            },

            addList() {
                // this.$emit('addNewList');
                console.log('open new list modal');
                const eventBus = new Vue();

                this.$modal.show(NewListAssitentModal, { eventBus: eventBus }, { height: 'auto', width: '50%' });

                eventBus.$on('addList', newListData => {
                    console.log('adding list', newListData);
                });
            },

            toggleShareListClick() {
                this.$emit('shareListToggle');
            }
        }
    };
</script>

<style lang="scss" scoped>
    .x5_custom_list {
        width: 100%;

        border-bottom: solid 1px #1f3f70;
        border-left: solid 1px #1f3f70;
        border-right: solid 1px #1f3f70;
    }
    .x5_list_header {
        width: 100%;
        height: 100%;

        display: flex;
        flex-direction: column;
        background-color: #e7ebf1;

        border: 1px solid #1f3f70;
    }

    .x5_headline {
        padding: 0.5em;

        font-weight: bold;
        font-size: 1.5em;

        color: #1f3f70;
        text-align: center;
        background-color: #e7ebf1;
    }

    .x5_button_line {
        display: flex;
        width: 100%;
    }

    .x5_button_container {
        text-align: center;

        width: 100%;

        padding-left: 0.5em;
        padding-right: 0.5em;
        background-color: #e7ebf1;
    }

    .x5_button_container .button {
        width: 100%;
    }

    .d {
        grid-column: 2;
        grid-row: 1;
    }

    .dropdown {
        position: relative;
        display: inline-block;

        width: 100%;
    }

    .dropdown_content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .choose_list {
        text-align: left;
        width: 100%;
    }

    .options_menu {
        min-width: 160px;
        right: 0;
    }

    .dropdown:hover .dropdown_content {
        display: block;
    }

    .customListEntry {
        cursor: pointer;
        line-height: 130%;
        color: #28497c;
        padding: 0.8em 0.6em 0.8em 0.6em;
    }

    .customListEntry:hover {
        background-color: #28497c;
        color: #ffffff;
    }

    .editListButton {
        font-size: 0.66em;
        line-height: 130%;
        cursor: pointer;
        padding: 0.8em 0.6em 0.8em 0.6em;
    }

    .editListButton:hover {
        background-color: #28497c;
        color: #ffffff;
    }

    .x5_current_list {
        font-size: 1.5em;
        color: #1f3f70;
        width: 100%;

        border-top: 1px solid #1f3f70;

        display: grid;
        grid-template-columns: 95% 5%;
    }

    .x5_current_list_text {
        padding: 0.4em;
        border: none;
    }

    .x5_current_list_text:disabled {
        background-color: #e7ebf1;
        color: #28497c;
        border: none;
        padding: 0.4em;
    }

    .x5_current_list img {
        width: 1.2em;
        height: 1.2em;

        padding-top: 0.4em;
        padding-right: 0.4em;

        cursor: pointer;
    }
</style>

