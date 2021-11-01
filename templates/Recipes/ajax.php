<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Recipe $recipe
 */
?>
<!--<div><?= h($recipe->name) ?></div>-->
<!--<div><?= h($recipe->description) ?></div>-->
<div class="card">
    <div class="card-header">
        <?= h($recipe->name) ?>
    </div>
    <div class="card-body">
        <h5 class="card-title btn-outline-primary">Beschreibung</h5>
        <ul class="list-group">
        <li class="list-group-item"><?= h($recipe->description) ?></li>
        </ul>
        <h5 class="card-title btn-outline-primary">Zutaten</h5>
        <ul class="list-group">
        <?php foreach ($recipe->ingredients as $ingredient) : ?>
            <li class="list-group-item"><?= h($ingredient->ingredient) ?></li>
        <?php endforeach; ?>
        </ul>
    </div>
</div>
