<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Recipe $recipe
 */
?>
<h1 class="page-header">Mothers Finest</h1>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('Bearbeite Rezept'), ['action' => 'edit', $recipe->id], ['class' => 'nav-link']) ?></li>
<li><?= $this->Form->postLink(__('Delete Recipe'), ['action' => 'delete', $recipe->id], ['confirm' => __('Are you sure you want to delete # {0}?', $recipe->id), 'class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('Rezepte'), ['action' => 'index'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('Neues Rezept'), ['action' => 'add'], ['class' => 'nav-link']) ?> </li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="recipes view large-9 medium-8 columns content">
    <h3><?= h($recipe->name) ?></h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th scope="row"><?= __('Name') ?></th>
                <td><?= h($recipe->name) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($recipe->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Erstellt') ?></th>
                <td><?= h($recipe->created) ?></td>
            </tr>
        </table>
    </div>
    <div>
        <h4><?= __('Beschreibung') ?></h4>
    </div>
    <div>
        <?= $this->Text->autoParagraph(h($recipe->description)); ?>
    </div>
</div>
