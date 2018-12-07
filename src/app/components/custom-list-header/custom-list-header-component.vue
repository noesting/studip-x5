<template>
    <div class="d x5_list_header">
        <div class="x5_headline">Meine Listen</div>

        <div class="x5_button_line">
            <div class="x5_button_container">
                <div class="dropdown">
                    <StudipButton :text="'Liste auswählen'"></StudipButton>
                    <div class="dropdown_content choose_list" id="choose_custom_list_select"></div>
                </div>
            </div>

            <div class="x5_button_container">
                <StudipButton :text="'Neue Liste'"></StudipButton>
            </div>
        </div>

        <div class="x5_current_list">
            <input
                type="text"
                value="Keine Liste ausgewählt"
                class="x5_current_list_text"
                id="x5_current_list_text"
                name="x5_current_list_text"
                disabled
            >
            <div class="dropdown">
                <div class="x5_item_action" name="x5_item_action">
                    <StudipIcon :icon_name="'action'" :color="'blue'"></StudipIcon>
                </div>
                <div class="dropdown_content options_menu">
                    <div class="editListButton" name="editListButton" id="shareListClick">Freigeben</div>
                    <div
                        class="editListButton"
                        name="editListButton"
                        id="renameListClick"
                    >Umbenennen</div>
                    <div class="editListButton" name="editListButton" id="deleteListClick">Löschen</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import StudipButton from '../studip-components/studip-button-component.vue';
    import StudipIcon from '../studip-components/studip-icon-button-component.vue';

    export default {
        components: {
            StudipButton,
            StudipIcon
        }
    };
</script>

<style lang="scss" scoped>
    .x5_custom_list {
        width: 100%;

        border-bottom: solid 1px #1f3f70;
        border-left: solid 1px #1f3f70;
        border-right: solid 1px #1f3f70;
    }
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

    .d {
        grid-column: 2;
        grid-row: 1;
    }

    .dropdown {
        position: relative;
        display: inline-block;

        width: 100%;
    }

    .dropdown_content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .choose_list {
        text-align: left;
        width: 100%;
    }

    .options_menu {
        min-width: 160px;
        right: 0;
    }

    .dropdown:hover .dropdown_content {
        display: block;
    }

    .customListEntry {
        cursor: pointer;
        line-height: 130%;
        color: #28497c;
        padding: 0.8em 0.6em 0.8em 0.6em;
    }

    .customListEntry:hover {
        background-color: #28497c;
        color: #ffffff;
    }

    .editListButton {
        font-size: 0.66em;
        line-height: 130%;
        cursor: pointer;
        padding: 0.8em 0.6em 0.8em 0.6em;
    }

    .editListButton:hover {
        background-color: #28497c;
        color: #ffffff;
    }

    .x5_current_list {
        font-size: 1.5em;
        color: #1f3f70;
        width: 100%;

        border-top: 1px solid #1f3f70;

        display: grid;
        grid-template-columns: 95% 5%;
    }

    .x5_current_list_text {
        padding: 0.4em;
        border: none;
    }

    .x5_current_list_text:disabled {
        background-color: #e7ebf1;
        color: #28497c;
        border: none;
        padding: 0.4em;
    }

    .x5_current_list img {
        width: 1.2em;
        height: 1.2em;

        padding-top: 0.4em;
        padding-right: 0.4em;

        cursor: pointer;
    }
</style>

