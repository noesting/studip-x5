<template>
    <div class="custom-list-item-detail-container">
        <div class="thumbnail-container"></div>

        <div class="content">
            <div class="title">{{ item.title }}</div>
            <div class="subtitle">{{ item.publishingYear }} - {{ item.author }}</div>
            <div class="description">{{ item.description }}</div>

            <div class="link">
                <a :href="itemLink" target="blank">{{ item.url }}</a>
            </div>

            <div class="interaction-grid-item">Gefällt mir 
                <div
                    name="like-button"
                    @click="likeItem"
                    class="x5_btn_like">
                    <h3>
                        <StudipIcon
                            v-if="itemLikedByUser"
                            :icon_name="'thumbs_up'"
                            :color="'blue'">
                        </StudipIcon>
                        <StudipIcon
                            v-else
                            :icon_name="'thumbs_up'" 
                            :color="'grey'">
                        </StudipIcon>
                    </h3>
                </div>
            </div>
        </div>
        <div class="right-placeholder"></div>
    </div>
</template>

<script>
    import StudipButton from '../studip-components/studip-button-component.vue';
    import StudipIcon from '../studip-components/studip-clickable-icon-component';

    export default {
        components: {
            StudipButton,
            StudipIcon
        },
        props: ['item', 'eventBus'],
        computed: {
            itemLink() {
                return getValidLink(this.item.url);
            }
        },
        data() {
            return {
                itemLikedByUser: this.item.userLiked
            }
        },
        methods: {
            likeItem() {
                console.log('like it!')
                this.itemLikedByUser = !this.itemLikedByUser;
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

    .x5_btn_like {
        width: 22px;
        grid-column: 2;
        cursor: pointer;
    }
</style>

<style lang="scss">
    .v--modal-overlay {
        background: rgba(40, 73, 124, 0.4);
    }
</style>


