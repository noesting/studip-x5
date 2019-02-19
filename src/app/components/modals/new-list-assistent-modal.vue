<template>
    <div class="new-list-assistent-modal-container">
        <div class="x5-header">Neue Liste anlegen
            <br>
        </div>

        <h3>Titel der Liste</h3>

        <input class="list_title_input" type="text" value="en" v-model="title">

        <h3>Für Studierende sichtbar ab</h3>

        <input type="date" value="text" v-model="releaseDate">

        <br>

        <StudipButton @studipbuttonClick="add" :text="'Anlegen'"></StudipButton>
        <StudipButton @studipbuttonClick="close" :text="'Abbrechen'"></StudipButton>
    </div>
</template>

<script>
    import StudipButton from '../studip-components/studip-button-component.vue';

    export default {
        components: {
            StudipButton
        },
        props: ['eventBus'],
        computed: {},
        data() {
            return {
                title: 'Neue Liste',
                releaseDate: new Date()
            };
        },
        methods: {
            add() {
                console.log('adding list with title', this.title, 'and date', this.releaseDate);
                this.eventBus.$emit('addList', { title: this.title, date: this.releaseDate });
                this.close();
            },

            close() {
                this.$emit('close');
                console.log('close');
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
