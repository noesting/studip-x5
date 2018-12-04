<?
if (isset($flash['error'])) {
    echo MessageBox::error($flash['error']);
}

if (isset($flash['message'])) {
    echo MessageBox::info($flash['message']);
}
?>

<div class="x5_dozent_view_container">
    <!-- <div class="box a">A</div>
    <div class="box b">B</div> -->
    <div class="c x5_list_header">
        <div class="x5_headline x5_list_header_section">
            Vorschläge
        </div>

        <div class="x5_searchbar x5_list_header_section">
            <input type="text" placeholder="Suche in X5" name="x5-search">
            <?=new Icon('search')?>
        </div>

        <div class="x5_button_line x5_list_header_section">
            <div class="x5_button_container">
                <?=\Studip\Button::create('Filter', 'filterButton');?>
            </div>

            <div class="x5_button_container">
                <?=\Studip\Button::create('Sortierung', 'sortButton');?>
            </div>
        </div>
    </div>

    <div class="d x5_list_header">
        <div class="x5_headline x5_list_header_section">
            Meine Listen
        </div>

        <div class="x5_button_line x5_list_header_section">
            <div class="x5_button_container">
                <div class="dropdown">
                    <?=\Studip\Button::create('Liste auswählen');?>
                    <div class="dropdown_content choose_list" id="choose_custom_list_select">
                    </div>
                </div>
            </div>

            <div class="x5_button_container x5_list_header_section">
                <?=\Studip\Button::create('Neue Liste', 'addListButton');?>
            </div>
        </div>

        <div class="x5_current_list">
            <input type="text" value="Keine Liste ausgewählt" class="x5_current_list_text" id="x5_current_list_text" name="x5_current_list_text" disabled>
            <div class="dropdown">
                <div class="x5_item_action" name="x5_item_action">
                    <?=new Icon('action')?>
                </div>
                <div class="dropdown_content options_menu">
                    <div class="editListButton" name="editListButton" id="shareListClick">Freigeben</div>
                    <div class="editListButton" name="editListButton" id="renameListClick">Umbenennen</div>
                    <div class="editListButton" name="editListButton" id="deleteListClick">Löschen</div>
                </div>
            </div>
        </div>
    </div>

    <div class="x5_material_list" id="x5_material_list">
    </div>

    <div class="x5_custom_list" id="x5_custom_list">
    </div>
</div>


<!-- <hr> -->

<!-- <?=\Studip\LinkButton::create(
    dgettext('x5', 'Foo starten'),
    $controller->url_for('oer/foo', 17)
)?> -->

<!-- <hr>

<form class="default" method="post" action="<?=$controller->url_for('oer/bar')?>">
    <fieldset>
        <legend>Somewhat</legend>

        <label>
            Label A
            <input type="text" name="bar1">
        </label>

        <label>
            Label B
            <input type="text" name="bar2">
        </label>
    </fieldset>

    <footer>
        <?=\Studip\Button::createAccept(dgettext('x5', 'Formular abschicken'))?>
        <?=\Studip\LinkButton::createCancel(
    dgettext('x5', 'Abbrechen'),
    $controller->url_for('oer/index')
)?>
    </footer>
</form> -->
