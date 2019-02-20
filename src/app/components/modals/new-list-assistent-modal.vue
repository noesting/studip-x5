<template>
    <div class="new-list-assistent-modal-container">
        <div class="x5-header">Neue Liste anlegen
            <br>
        </div>

        <h3>Titel der Liste</h3>

        <input class="list_title_input" type="text" maxlength="160" v-model="title">

        <h3>Für Studierende sichtbar ab</h3>

        <Datepicker
            v-model="releaseDate"
            name="releaseDatePicker"
            :calendar-class="'x5_calendar'"
            :language="language.de"
            :format="'dd.MM.yyyy'"
        ></Datepicker>

        <br>

        <StudipButton @studipbuttonClick="add" :text="'Anlegen'"></StudipButton>
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
        props: ['eventBus'],
        data() {
            return {
                title: 'Neue Liste',
                releaseDate: new Date(),
                language: {
                    en,
                    de
                }
            };
        },
        methods: {
            add() {
                this.eventBus.$emit('addList', { title: this.title, date: this.releaseDate });
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
