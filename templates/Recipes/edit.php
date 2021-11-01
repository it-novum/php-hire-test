<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Recipe $recipe
 */
?>
<h1 class="page-header">Mothers Finest</h1>
<?php $this->extend('/layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Form->postLink(__('Löschen'), ['action' => 'delete', $recipe->id], ['confirm' => __('Sind Sie sicher?', $recipe->id), 'class' => 'nav-link h6 btn-danger', 'style' => 'color:white;']) ?></li>
<li><?= $this->Html->link(__('Rezepte'), ['action' => 'index'], ['class' => 'nav-link h6 btn-secondary', 'style' => 'color:white;']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="recipes form content">
    <?= $this->Form->create($recipe) ?>
    <fieldset>
        <legend><?= __('Bearbeite Rezept') ?></legend>
        <?php
        echo $this->Form->control('name');
        echo $this->Form->control('description', ['label' => 'Beschreibung']);
        ?>
        <row>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label col-form-label-lg">Zutaten</label>
            </div>
        </row>
        <div class="input_fields_wrap_edit">
            <?php foreach ($recipe->ingredients as $ingredient) : ?>
                <row>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label col-form-label-lg" for="name">Zutat</label>
                        <div class="col-sm-8">
                            <input type="text" name="Ingredients[]" class="form-control"
                                   value=<?= h($ingredient->ingredient) ?> maxlength="255"/>
                        </div>
                        <div class="col-sm-2">
                            <a href="#" class="remove_field form-control btn btn-danger">Entferne</a>
                        </div>
                    </div>
                </row>
            <?php endforeach; ?>
        </div>
        <div class="input_fields_wrap">
        </div>
        <div class="form-group row">
            <div class="col-sm-2">
                <a href="#" class="form-control btn btn-info zutat">Neue Zutat</a>
            </div>
        </div>
    </fieldset>
    <?= $this->Form->button(__('Speichern')) ?>
    <?= $this->Form->end() ?>
</div>
<script src="/bootstrap_u_i/js/jquery.js"></script>
<script>
    $(function () {
        var max_fields = 15; //maximum input boxes allowed
        var wrapper = $(".input_fields_wrap"); //Fields wrapper
        var x = 1; //initial text box count
        $('.zutat').on('click', function (e) { //on add input button click
            e.preventDefault();
            if (x < max_fields) { //max input box allowed
                $(wrapper).append('<row><div class="form-group row"><label class="col-sm-2 col-form-label col-form-label-lg" for="name">Zutat</label><div class="col-sm-8"><input type="text" name="Ingredients[]" class="form-control" value="" maxlength="255"/></div><div class="col-sm-2"><a href="#" class="remove_field form-control btn btn-danger">Entferne</a></div></div></row>');
            }
        });
        $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text
            e.preventDefault();
            $(this).parents('row').remove();
            x--;
        });
        $(wrapper_edit).on("click", ".remove_field", function (e) { //user click on remove text
            e.preventDefault();
            $(this).parents('row').remove();
        });
    });
</script>
