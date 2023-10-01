<?php echo $this->HTML->css('recipes/index'); ?>
<?php echo $this->HTML->script('recipes/index'); ?>

<div class="row">

<div class="col-lg-8">
    <h2>All Recipes</h2>
</div>

<div class="col-lg-4">
<?= $this->Form->text('search', ['class' => 'form-control', 'id' => 'search', 'placeholder' => 'Search for recipes...']); ?>
</div>

</div>

<div class="row">

    <div class="col-lg-2 form-group">
        <?= $this->Form->control('sort', 
        ['type' => 'select', 'id' => 'sort', 'class' => 'form-control', 'options' => $sortOptions, 'value' => $selectedSortOption]); ?>
    </div>

    <div class="col-lg-12">
        
        <table class="table" id="recipesTable">
            <tr>
                <th>Title</th>
                <th>Created</th>
            </tr>

            <?php if ($recipes->count()): ?>
                <?php foreach ($recipes as $recipe): ?>
                <tr>
                    <td><?= $this->Html->link($recipe->title, ['action' => 'view', $recipe->id], ['class' => 'title-link']) ?></td>
                    <td><?= h($recipe->created->format('d.m.Y')); ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2">No Recipes</td>
                </tr>
            <?php endif; ?>
        </table>

    </div>

    <div class="preview-overlay" id="previewOverlay">

    </div>

</div>