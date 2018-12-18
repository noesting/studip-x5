<template>
    <div class="item-detail-container">
        <div class="title">{{ item.title }}</div>
        <div class="subtitle">{{ item.publishingYear }} - {{ item.author }}</div>
        <div class="description">{{ item.description }}</div>

        <div class="description">{{ item.link }}</div>

        <div class="interaction-fields">
            <div class="interaction-grid-item">
                Sichtbar für Studenten ab dem
                <input value="dateString()" @click="pickDate">
            </div>
            <div class="interaction-grid-item">
                Kommentarfeld
                <textarea rows="4"></textarea>
            </div>
            <div class="interaction-grid-item">Bewertung
                <StudipButton :text="'Bewerten'"></StudipButton>
            </div>
        </div>
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
        computed: {
            dateString() {
                return (
                    this.visibleDate.date() + '.' + (this.visibleDate.month() + 1) + '.' + this.visibleDate.currentYear()
                );
            }
        },
        data() {
            return {
                visibleDate: new Date()
            };
        },
        methods: {
            pickDate() {
                console.log('picking date');
            }
        }
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
    }

    .subtitle {
        margin-bottom: 1.5em;
    }

    .interaction-fields {
        margin: 1em;
        display: grid;
        grid-template-columns: 33% 33% 33%;
        grid-column-gap: 10px;
    }

    .interaction-grid-item {
        padding: 1em;
        background-color: #d4dbe5;
    }
</style>

<style lang="scss">
    .v--modal-overlay {
        background: rgba(40, 73, 124, 0.4);
    }
</style>


