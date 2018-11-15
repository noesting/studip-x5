<?
if (isset($flash['error'])) {
    echo MessageBox::error($flash['error']);
}

if (isset($flash['message'])) {
    echo MessageBox::info($flash['message']);
}
?>

<div>
    <?= \Studip\Button::create('Vorschläge', 'klickMichButton', array('data-dialog-button' => '1', 'data-hallo' => 'welt')); ?>
    <?= \Studip\Button::create('Suche', 'klickMichButton', array('data-dialog-button' => '1', 'data-hallo' => 'welt')); ?>
    <?= \Studip\Button::create('Meine Listen', 'klickMichButton', array('data-dialog-button' => '1', 'data-hallo' => 'welt')); ?>
</div>

<br>

<h1>Meine Listen</h1>


<div class="x5-default-list">
    <h3>Meine Materialien</h3>

    <div class="x5-default-list-item">
        <div class="x5-item-thumbnail">
        </div>

        <div class="x5-item-inner">
            Möbelindustrue 2030: Super krasse Möbel möblieren das ohnehin fantastische Mobiliar
        </div>

        <div class="x5-item-action">
            <h3><?= new Icon('action') ?></h3>
        </div>
    </div>

    <div class="x5-default-list-item">
        <div class="x5-item-thumbnail">
        </div>

        <div class="x5-item-inner">
            Lange Titel: Studien zeigen, dass ein äußerst langer Titel weder besonders einprägsam, noch in irgendeiner Weise Praktisch ist
        </div>

        <div class="x5-item-action">
            <h3><?= new Icon('action') ?></h3>
        </div>
    </div>

    <div class="x5-default-list-item">
        <div class="x5-item-thumbnail">
        </div>

        <div class="x5-item-inner">
        Es geht auch kurz
        </div>

        <div class="x5-item-action">
            <h3><?= new Icon('action') ?></h3>
        </div>
    </div>

    <div class="x5-default-list-item">
        <div class="x5-item-thumbnail">
        </div>

        <div class="x5-item-inner">
            Möbelindustrue 2030: Super krasse Möbel möblieren das ohnehin fantastische Mobiliar
        </div>

        <div class="x5-item-action">
            <h3><?= new Icon('action') ?></h3>
        </div>
    </div>

    <div class="x5-default-list-item">
        <div class="x5-item-thumbnail">
        </div>

        <div class="x5-item-inner">
            Möbelindustrue 2030: Super krasse Möbel möblieren das ohnehin fantastische Mobiliar
        </div>

        <div class="x5-item-action">
            <h3><?= new Icon('action') ?></h3>
        </div>
    </div>

    <div class="x5-default-list-item">
        <div class="x5-item-thumbnail">
        </div>

        <div class="x5-item-inner">
            Möbelindustrue 2030: Super krasse Möbel möblieren das ohnehin fantastische Mobiliar
        </div>

        <div class="x5-item-action">
            <h3><?= new Icon('action') ?></h3>
        </div>
    </div>
</div>


<div class="x5-custom-list">
    <h3>Titelsammlungen</h3>

    <div class="x5-list-item">
        <div class="x5-item-thumbnail">
        </div>

        <div class="x5-item-inner">
            Möbelindustrue 2030: Super krasse Möbel möblieren das ohnehin fantastische Mobiliar
        </div>

        <div class="x5-item-action">
            <h3><?= new Icon('action') ?></h3>
        </div>
    </div>

    <div class="x5-list-item">
        <div class="x5-item-thumbnail">
        </div>

        <div class="x5-item-inner">
            Lange Titel: Studien zeigen, dass ein äußerst langer Titel weder besonders einprägsam, noch in irgendeiner Weise Praktisch ist
        </div>

        <div class="x5-item-action">
            <h3><?= new Icon('action') ?></h3>
        </div>
    </div>

    <div class="x5-list-item">
        <div class="x5-item-thumbnail">
        </div>

        <div class="x5-item-inner">
            Es geht auch kurz
        </div>

        <div class="x5-item-action">
            <h3><?= new Icon('action') ?></h3>
        </div>
    </div>
</div>

<div class="x5-custom-list">
    <h3>Kleine Sammlung</h3>

    <div class="x5-list-item">
        <div class="x5-item-thumbnail">
        </div>

        <div class="x5-item-inner">
            Möbelindustrue 2030: Super krasse Möbel möblieren das ohnehin fantastische Mobiliar
        </div>

        <div class="x5-item-action">
            <h3><?= new Icon('action') ?></h3>
        </div>
    </div>
</div>

<div class="x5-custom-list">
    <h3>Andere Reihenfolge</h3>

    <div class="x5-list-item">
        <div class="x5-item-thumbnail">
        </div>

        <div class="x5-item-inner">
            Es geht auch kurz
        </div>

        <div class="x5-item-action">
            <h3><?= new Icon('action') ?></h3>
        </div>
    </div>

    <div class="x5-list-item">
        <div class="x5-item-thumbnail">
        </div>

        <div class="x5-item-inner">
            Möbelindustrue 2030: Super krasse Möbel möblieren das ohnehin fantastische Mobiliar
        </div>

        <div class="x5-item-action">
            <h3><?= new Icon('action') ?></h3>
        </div>
    </div>

    <div class="x5-list-item">
        <div class="x5-item-thumbnail">
        </div>

        <div class="x5-item-inner">
            Lange Titel: Studien zeigen, dass ein äußerst langer Titel weder besonders einprägsam, noch in irgendeiner Weise Praktisch ist
        </div>

        <div class="x5-item-action">
            <h3><?= new Icon('action') ?></h3>
        </div>
    </div>
</div>

<div class="x5-custom-list">
    <h3>Nur lange Titel</h3>

    <div class="x5-list-item">
        <div class="x5-item-thumbnail">
        </div>

        <div class="x5-item-inner">
            Lange Titel: Studien zeigen, dass ein äußerst langer Titel weder besonders einprägsam, noch in irgendeiner Weise Praktisch ist
        </div>

        <div class="x5-item-action">
            <h3><?= new Icon('action') ?></h3>
        </div>
    </div>

    <div class="x5-list-item">
        <div class="x5-item-thumbnail">
        </div>

        <div class="x5-item-inner">
            Möbelindustrue 2030: Super krasse Möbel möblieren das ohnehin fantastische Mobiliar
        </div>

        <div class="x5-item-action">
            <h3><?= new Icon('action') ?></h3>
        </div>
    </div>
</div>

<!-- <hr> -->

<!-- <?= \Studip\LinkButton::create(
    dgettext('x5', 'Foo starten'),
    $controller->url_for('oer/foo', 17)
) ?> -->

<!-- <hr>

<form class="default" method="post" action="<?= $controller->url_for('oer/bar') ?>">
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
        <?= \Studip\Button::createAccept(dgettext('x5', 'Formular abschicken'))?>
        <?= \Studip\LinkButton::createCancel(
            dgettext('x5', 'Abbrechen'),
            $controller->url_for('oer/index')
        )?>
    </footer>
</form> -->
