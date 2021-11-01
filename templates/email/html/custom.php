<h5>Hallo Gourmet,</h5>
<div>
    <p>probieren geht über studieren!</p>
</div>
<div>
    <p>Wie wäre es mit folgendem Rezept?</p>
</div>

<div>
    <?= h($recipe->name) ?>
</div>
<div>
    <h5>Beschreibung</h5>
</div>
<div>
    <p><?= h($recipe->description) ?></p>
</div>
<div>
    <h5>Zutaten</h5>
</div>
<div>
    <ul>
    <?php foreach ($recipe->ingredients as $ingredient) : ?>
        <li><?= h($ingredient->ingredient) ?></li>
    <?php endforeach; ?>
    </ul>
</div>
<div>
    Guten Appetit!
</div>

