<template>
    <div class="item-detail-container">
        <div class="thumbnail-container"></div>

        <div class="content">
            <div class="title">{{ item.title }}</div>
            <div class="subtitle">{{ item.publishingYear }} - {{ item.author }}</div>
            <div class="description">{{ item.description }}</div>

            <div class="link">
                <a :href="itemLink" target="blank">{{ item.link }}</a>
            </div>

            <div class="interaction-fields">
                <div class="interaction-grid-item">
                    Sichtbar für Studenten ab dem {{ dateString }}<br>
                    <StudipButton :text="'Datum auswählen'"></StudipButton>
                </div>
                <div class="interaction-grid-item">
                    Kommentarfeld
                    <textarea class="comment-text-area" rows="4"></textarea>
                </div>
                <div class="interaction-grid-item">Bewertung<br>
                    <StudipButton :text="'Bewerten'"></StudipButton>
                </div>
            </div>
        </div>

        <div class="right-placeholder"></div>
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
                return getDateInGermanFormat(this.visibleDate);
            },

            itemLink() {
                return getValidLink(this.item.link);
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

    const getDateInGermanFormat = date => {
        const day = date.getDate() >= 10 ? date.getDate() : '0' + date.getDate();
        const month = date.getMonth() >= 9 ? date.getMonth() + 1 : '0' + (date.getMonth() + 1);
        const year = date.getFullYear();

        return day + '.' + month + '.' + year;
    };

    const getValidLink = link => {
        const includes = link.includes('http');
        if (includes) {
            return link;
        }

        return 'https://' + link;
    };
</script>

<style lang="scss" scoped>
    .item-detail-container {
        padding: 1em;
        color: #1f3f70;
        background-color: #e7ebf1;

        display: grid;
        grid-template-columns: 15% 70% 15%;

        height: 100%;
    }

    .title {
        font-size: 1.5em;
        font-weight: bold;
    }

    .subtitle {
        margin-bottom: 1.5em;
    }

    .link {
        margin-top: 1.5em;
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

    .comment-text-area {
        width: 100%;
    }

    input {
        width: 100%;
    }
</style>

<style lang="scss">
    .v--modal-overlay {
        background: rgba(40, 73, 124, 0.4);
    }
</style>


