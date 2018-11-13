<?
if (isset($flash['error'])) {
    echo MessageBox::error($flash['error']);
}

if (isset($flash['message'])) {
    echo MessageBox::info($flash['message']);
}
?>

<p>
    Es gibt im Moment in diese Mannschaft, oh, einige Spieler
    vergessen ihren Profi was sie sind. Ich lese nicht sehr viele
    Zeitungen, aber ich habe gehört viele Situationen.
</p>
<p>
    Wir haben nicht offensiv gespielt. Es gibt keine deutsche
    Mannschaft spielt offensiv und die Namen offensiv wie Bayern.
    Letzte Spiel hatten wir in Platz drei Spitzen: Elber, Jancker und
    dann Zickler. Wir mussen nicht vergessen Zickler. Zickler ist eine
    Spitzen mehr, Mehmet mehr Basler.
</p>
<p>
    Ist klar diese Wörter, ist möglich verstehen, was ich hab' gesagt?
    Danke. Offensiv, offensiv ist wie machen in Platz.
</p>
<p>
    Ich habe erklärt mit diese zwei Spieler: Nach Dortmund brauchen
    vielleicht Halbzeit Pause. Ich habe auch andere Mannschaften
    gesehen in Europa nach diese Mittwoch. Ich habe gesehen auch zwei
    Tage die Training. Ein Trainer ist nicht ein Idiot! Ein Trainer
    sehen was passieren in Platz. In diese Spiel es waren zwei, drei
    oder vier Spieler, die waren schwach wie eine Flasche leer!
</p>
<p>
    Haben Sie gesehen Mittwoch, welche Mannschaft hat gespielt
    Mittwoch? Hat gespielt Mehmet, oder gespielt Basler, oder gespielt
    Trapattoni? Diese Spieler beklagen mehr als sie spielen!
</p>
<p>
    Wissen Sie, warum die Italien-Mannschaften kaufen nicht diese
    Spieler? Weil wir haben gesehen viele Male solche Spiel. Haben
    gesagt, sind nicht Spieler für die italienische Meisters.
</p>
<p>
    Struuunz! Strunz ist zwei Jahre hier, hat gespielt zehn Spiele,
    ist immer verletzt. Was erlauben Strunz?! Letzte Jahre Meister
    geworden mit Hamann, eh Nerlinger. Diese Spieler waren Spieler und
    waren Meister geworden. Ist immer verletzt! Hat gespielt 25 Spiele
    in diese Mannschaft, in diese Verein. Muss respektieren die andere
    Kollegen!
</p>
<p>
    Haben viele Kollegen, stellen sie die Kollegen in Frage! Haben
    keine Mut an Worten, aber ich weiß, was denken über diese Spieler.
    Mussen zeigen jetzt, ich will, Samstag, diese Spieler mussen
    zeigen mich, eh..., seine Fans, mussen alleine die Spiel gewinnen.
    Muss allein die Spiel gewinnen!
</p>
<p>
    Ich bin müde jetzt Vater diese Spieler, eh..., verteidige immer
    diese Spieler. Ich habe immer die Schulde... über diese Spieler.
    Einer ist Mario, ein anderer ist Mehmet. Strunz dagegen, egal, hat
    nur gespielt 25 Prozent diese Spiele!
</p>
<p>
    Ich habe fertig.
</p>

<hr>

<?= \Studip\LinkButton::create(
    dgettext('x5', 'Foo starten'),
    $controller->url_for('oer/foo', 17)
) ?>

<hr>

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
</form>
