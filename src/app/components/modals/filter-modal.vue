<template>
    <div class="filter-container">
        <div class="x5-header">Filter
            <br>
        </div>

        <h3>Sprache</h3>

        <input type="checkbox" name="vehicle1" value="Bike">Englisch
        <br>
        <input type="checkbox" name="vehicle1" value="Bike">Deutsch
        <br>
        <input type="checkbox" name="vehicle1" value="Bike">Französisch
        <br>
        <input type="checkbox" name="vehicle1" value="Bike">Spanisch
        <br>

        <h3>Format</h3>

        <input type="checkbox" name="vehicle1" value="Bike">Text
        <br>
        <input type="checkbox" name="vehicle1" value="Bike">Video
        <br>
        <input type="checkbox" name="vehicle1" value="Bike">Audio
        <br>
        <input type="checkbox" name="vehicle1" value="Bike">Website
        <br>

        <h3>Erscheinungsdatum</h3>Frühestes Erscheinungsdatum
        <input type="date">
        <br>Spätestes Erscheinungsdatum
        <input type="date">
        <br>

        <StudipButton :text="'OK'"></StudipButton>
    </div>
</template>

<script>
    import StudipButton from '../studip-components/studip-button-component.vue';
    import StudipIcon from '../studip-components/studip-icon-button-component.vue';

    export default {
        components: {
            StudipButton
        },
        props: ['item'],
        computed: {},
        data() {
            return {};
        },
        methods: {}
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
