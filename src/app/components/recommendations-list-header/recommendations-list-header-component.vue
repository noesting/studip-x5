<template>
    <div class="c x5_list_header">
        <div class="x5_headline x5_list_header_section">Vorschläge</div>

        <div class="x5_searchbar x5_list_header_section">
            <input
                type="text"
                placeholder="Suche in X5"
                name="x5-search"
                @keyup.enter="search"
                v-model="searchtext"
            >
            <StudipIcon :icon_name="'search'" :color="'blue'"></StudipIcon>
        </div>

        <div class="x5_button_line x5_list_header_section">
            <div class="x5_button_container">
                <StudipButton @studipbuttonClick="showFilterModal" v-bind:text="'Filter'"></StudipButton>
            </div>
            <div class="x5_button_container">
                <StudipButton v-bind:text="'Sortierung'"></StudipButton>
            </div>
        </div>
    </div>
</template>

<script>
    import StudipButton from '../studip-components/studip-button-component.vue';
    import StudipIcon from '../studip-components/studip-clickable-icon-component';
    import FilterModal from '../modals/filter-modal';

    export default {
        components: {
            StudipButton,
            StudipIcon,
            FilterModal
        },
        props: ['filters'],
        data() {
            return {
                searchtext: '',
                checkedLangs: []
            };
        },
        methods: {
            showFilterModal() {
                const eventBus = new Vue();
                this.$modal.show(
                    FilterModal,
                    { eventBus: eventBus, filters: this.filters },
                    { height: 'auto', width: '40%' }
                );

                eventBus.$on('setRecommendationsFilters', filters => {
                    this.filters = filters;
                    this.applyFilter(filters);
                });
            },

            applyFilter(filters) {
                console.log('applying filters', filters);
                this.$emit('applyFilters', filters);
            },

            search() {
                const searchtext = this.searchtext.trim();
                this.$emit('searchClicked', searchtext);
            }
        }
    };
</script>

<style lang="scss" scoped>
    .x5_list_header {
        width: 100%;
        height: 100%;

        display: flex;
        flex-direction: column;
        background-color: #e7ebf1;

        border: 1px solid #1f3f70;
    }

    .x5_headline {
        padding: 0.5em;

        font-weight: bold;
        font-size: 1.5em;

        color: #1f3f70;
        text-align: center;
        background-color: #e7ebf1;
    }

    .x5_searchbar {
        padding: 0.5em;
        background-color: #e7ebf1;
    }

    .x5_searchbar input {
        width: 90%;
        height: 2em;
    }

    .x5_button_line {
        display: flex;
        width: 100%;
    }

    .x5_button_container {
        text-align: center;

        width: 100%;

        padding-left: 0.5em;
        padding-right: 0.5em;
        background-color: #e7ebf1;
    }

    .x5_button_container .button {
        width: 100%;
    }
</style>

