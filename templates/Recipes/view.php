<?php echo $this->HTML->css('recipes/view'); ?>

<div class="row">

    <div class="col-lg-9">
        <h2><?= h($recipe->title) ?></h2>
    </div>

    <div class="col-lg-3">
    Created: <?= h($recipe->created->format('d.m.Y')); ?>
    </div>

</div>

<div class="row">

    <div class="col-lg-12">
        <h3>Ingredients</h3>
    </div>

    <div class="col-lg-12">
        
        <table class="table">
            <?php foreach ($recipe->ingredients as $ingredient): ?>
            <tr>
                <td>
                    <?php 
                    echo h($ingredient->amount);
                    echo h($ingredient->unit);
                    echo " "; 
                    echo h($ingredient->description); 
                    ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

    </div>

</div>

<div class="row">

    <div class="col-lg-12">
        <p class="description">
        <?= h($recipe->description) ?>
        </p>
    </div>
 
</div>