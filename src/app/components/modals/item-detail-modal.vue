<template>
    <div class="item-detail-container">
        <div class="title">{{ item.title }}</div>
        <div class="description">{{ item.description }}</div>

        <div class="description">{{ item.link }}</div>

        <div class="interaction-fields">
            <div>Sichtbar für Studenten ab dem</div>
            <div>Kommentarfeld</div>
            <div>Bewertung</div>
        </div>
    </div>
</template>

<script>
    import StudipButton from '../studip-components/studip-button-component.vue';
    import StudipIcon from '../studip-components/studip-icon-button-component.vue';

    export default {
        components: {},
        props: ['item'],
        computed: {},
        methods: {}
    };
</script>

<style lang="scss" scoped>
    .item-detail-container {
        padding: 1em;
        color: #1f3f70;
        background-color: #e7ebf1;

        height: 100%;
    }

    .title {
        font-size: 1.5em;
        font-weight: bold;
        margin-bottom: 1em;
    }

    .interaction-fields {
        margin: 1em;
        display: grid;
        grid-template-columns: 33% 33% 33%;
    }
</style>

<style lang="scss">
    .v--modal-overlay {
        background: rgba(40, 73, 124, 0.4);
    }
</style>


