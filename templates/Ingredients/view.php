<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Ingredient $ingredient
 */
?>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('Edit Ingredient'), ['action' => 'edit', $ingredient->id], ['class' => 'nav-link']) ?></li>
<li><?= $this->Form->postLink(__('Delete Ingredient'), ['action' => 'delete', $ingredient->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ingredient->id), 'class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Ingredients'), ['action' => 'index'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('New Ingredient'), ['action' => 'add'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('List Recipes'), ['controller' => 'Recipes', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Recipe'), ['controller' => 'Recipes', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="ingredients view large-9 medium-8 columns content">
    <h3><?= h($ingredient->id) ?></h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th scope="row"><?= __('Recipe') ?></th>
                <td><?= $ingredient->has('recipe') ? $this->Html->link($ingredient->recipe->name, ['controller' => 'Recipes', 'action' => 'view', $ingredient->recipe->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Ingredient') ?></th>
                <td><?= h($ingredient->ingredient) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($ingredient->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($ingredient->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($ingredient->modified) ?></td>
            </tr>
        </table>
    </div>
</div>
