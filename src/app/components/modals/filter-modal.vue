<template>
    <div class="filter-container">
        <div class="x5-header">Filter
            <br>
        </div>

        <h3>Sprache</h3>

        <input type="checkbox" value="en" v-model="filters.checkedLangs">Englisch
        <br>
        <input type="checkbox" value="de" v-model="filters.checkedLangs">Deutsch
        <br>

        <h3>Format</h3>

        <input type="checkbox" value="text" v-model="filters.checkedFormats">Text
        <br>
        <input type="checkbox" value="video" v-model="filters.checkedFormats">Video
        <br>
        <input type="checkbox" value="audio" v-model="filters.checkedFormats">Audio
        <br>
        <input type="checkbox" value="image" v-model="filters.checkedFormats">Bild
        <br>

        <!-- <h3>Erscheinungsdatum</h3>Frühestes Erscheinungsdatum
        <input type="date">
        <br>Spätestes Erscheinungsdatum
        <input type="date">
        <br>-->
        <StudipButton @studipbuttonClick="applyFilters" :text="'OK'"></StudipButton>
    </div>
</template>

<script>
    import StudipButton from '../studip-components/studip-button-component.vue';
    import StudipIcon from '../studip-components/studip-icon-button-component.vue';

    export default {
        components: {
            StudipButton
        },
        props: ['eventBus', 'filters'],
        computed: {},
        data() {
            return {
                // filters: {
                //     checkedLangs: [],
                //     checkedFormats: []
                // }
            };
        },
        beforeDestroy() {
            this.eventBus.$emit('setRecommendationsFilters', this.filters);
        },
        methods: {
            applyFilters() {
                this.$emit('close');
            }
        }
    };
</script>

<style lang="scss" scoped>
    .filter-container {
        padding: 1em;
        color: #1f3f70;
        background-color: #e7ebf1;
    }

    .x5-header {
        margin-bottom: 1.5em;
        color: #1f3f70;
        font-size: 1.5em;
        font-weight: bold;
    }
</style>
