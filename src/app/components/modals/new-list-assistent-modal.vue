<template>
    <div class="new-list-assistent-modal-container">
        <div class="x5-header">Neue Liste anlegen
            <br>
        </div>

        <h3>Titel der Liste</h3>

        <input class="list_title_input" type="text" maxlength="160" v-model="title">

        <h3>Für Studierende sichtbar ab</h3>

        <!-- <input type="text" class="has-date-picker" :value="dateText"> -->
        <input type="text" class="has-date-picker" v-model="releaseDate" ref="dateInput">

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
        mounted() {
            console.log('ref', this.$refs.dateInput);
            this.$refs.dateInput.addEventListener('change', function(event) {
                console.log('change', event);
            });
        },
        props: ['eventBus'],
        data() {
            return {
                title: 'Neue Liste',
                releaseDate: this.formatDate(new Date())
            };
        },
        methods: {
            add() {
                const date = this.getDateFromString(this.releaseDate);
                console.log('adding list with title', this.title, 'and date', date);
                this.eventBus.$emit('addList', { title: this.title, date: date });
                this.close();
            },

            close() {
                this.$emit('close');
                console.log('close');
            },

            getDateFromString(dateString) {
                if (!dateString) {
                    return null;
                }

                dateString.trim();

                const dateArray = dateString.split('.');
                console.log('dateArray', dateArray);
                if (dateArray.length !== 3) {
                    return null;
                }

                return new Date(dateArray[2], --dateArray[1], dateArray[0]);
            },

            formatDate(date) {
                const day = date.getDate() < 10 ? '0' + date.getDate() : date.getDate();
                const month = date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1;
                return day + '.' + month + '.' + date.getFullYear();
            },

            updateReleaseDate(event) {
                console.log('updating to', event);
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
