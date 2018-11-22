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
    <div class="c x5_search_area">
        <div class="x5_headline">
            Vorschläge
        </div>

        <div class="x5_searchbar">
            <input type="text" placeholder="Suche in X5" name="x5-search">
            <?=new Icon('search')?>
        </div>

        <div class="x5_button_line">
            <div class="x5_button_container">
                <?=\Studip\Button::create('Filter', 'filterButton', array('data-dialog-button' => '1', 'data-hallo' => 'welt'));?>
            </div>

            <div class="x5_button_container">
                <?=\Studip\Button::create('Sortierung', 'sortButton', array('data-dialog-button' => '1', 'data-hallo' => 'welt'));?>
            </div>
        </div>
    </div>

    <div class="d x5_list_managing_area">
        <div class="x5_headline">
            Meine Listen
        </div>

        <div class="x5_button_line">
            <div class="x5_button_container">
                <?=\Studip\Button::create('Liste auswählen', 'filterButton', array('data-dialog-button' => '1', 'data-hallo' => 'welt'));?>
            </div>

            <div class="x5_button_container">
                <?=\Studip\Button::create('Neue Liste', 'sortButton', array('data-dialog-button' => '1', 'data-hallo' => 'welt'));?>
            </div>
        </div>

        <div class="x5_current_list">
            Liste
            <?=new Icon('action')?>
        </div>
    </div>

    <div class="x5_material_list">
    </div>

    <div class="x5_custom_list">
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
