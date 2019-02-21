<template>
    <div class="new-list-assistent-modal-container">
        <div class="x5-header">
            {{ headerText }}
            <br>
        </div>

        <h3>Titel der Liste</h3>

        <input class="list_title_input" type="text" maxlength="160" v-model="list.title">

        <h3>Für Studierende sichtbar ab</h3>

        <Datepicker
            v-model="list.releaseDate"
            name="releaseDatePicker"
            :calendar-class="'x5_calendar'"
            :language="language.de"
            :format="'dd.MM.yyyy'"
        ></Datepicker>

        <br>

        <StudipButton @studipbuttonClick="save" :text="saveButtonText"></StudipButton>
        <StudipButton @studipbuttonClick="close" :text="'Abbrechen'"></StudipButton>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import { en, de } from 'vuejs-datepicker/dist/locale';
    import StudipButton from '../studip-components/studip-button-component.vue';

    export default {
        components: {
            Datepicker,
            StudipButton
        },
        props: ['eventBus', 'listFromParent'],
        data() {
            return {
                language: {
                    en,
                    de
                },
                list: {
                    title: 'Neue Liste',
                    releaseDate: new Date()
                }
            };
        },
        computed: {
            headerText() {
                return this.isUpdateModal() ? 'Liste aktualisieren' : 'Neue Liste anlegen';
            },

            saveButtonText() {
                return this.isUpdateModal() ? 'Speichern' : 'Anlegen';
            }
        },
        created() {
            this.initList();
        },
        methods: {
            initList() {
                if (this.listFromParent && this.listFromParent.id) {
                    this.list = this.listFromParent;
                }
                console.log('this.listFromParent', this.listFromParent);
                console.log('this.list', this.list);
            },

            isUpdateModal() {
                return this.list && this.list.id;
            },

            save() {
                if (this.list.id) {
                    this.eventBus.$emit('updateList', this.list);
                } else {
                    this.eventBus.$emit('addList', this.list);
                }
                this.close();
            },

            close() {
                this.$emit('close');
            }
        }
    };
</script>

<style lang="scss" scoped>
    .new-list-assistent-modal-container {
        padding: 1em;
        color: #1f3f70;
        background-color: #e7ebf1;
    }

    .list_title_input {
        width: 100%;
        max-width: 40em;
    }

    .x5-header {
        margin-bottom: 1.5em;
        color: #1f3f70;
        font-size: 1.5em;
        font-weight: bold;
    }
</style>

<style lang="scss">
    .x5_calendar {
        position: fixed;
        z-index: 1000;
    }

    .vdp-datepicker__calendar .cell.selected {
        background-color: #1f3f70;
        color: #ffffff;
    }

    .vdp-datepicker__calendar .cell.selected:hover {
        background-color: #1f3f70;
        color: #ffffff;
    }

    .vdp-datepicker__calendar .cell:not(.blank):not(.disabled).day:hover {
        border: 1px solid #1f3f70;
    }
</style>
