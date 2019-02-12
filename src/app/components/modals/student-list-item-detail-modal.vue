<template>
    <div class="custom-list-item-detail-container">
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
                    Kommentarfeld
                    <textarea
                        class="comment-text-area"
                        rows="4"
                        v-model="item.comment"
                        disabled
                    ></textarea>
                </div>
                <div class="interaction-grid-item">Bewertung
                    <StudipButton @studipbuttonClick="likeItem" :text="'Bewerten'"></StudipButton>
                    <br>
                    <span v-if="item.userLiked">Bewertet</span>
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
        props: ['item', 'eventBus'],
        computed: {
            itemLink() {
                console.log('this.item', this.item);
                return getValidLink(this.item.link);
            }
        },
        // data() {},
        methods: {
            likeItem() {
                this.eventBus.$emit('like', this.item);
            }
        }
    };

    const getValidLink = link => {
        if (!link) {
            return '';
        }

        const includes = link.includes('http');
        if (includes) {
            return link;
        }

        return 'https://' + link;
    };
</script>

<style lang="scss" scoped>
    .custom-list-item-detail-container {
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


