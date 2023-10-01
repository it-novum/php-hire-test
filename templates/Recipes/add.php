<?php echo $this->HTML->css('recipes/add'); ?>
<?php echo $this->HTML->script('recipes/add'); ?>

<div class="row">

<div class="col-lg-12">
    <h2>New Recipe</h2>
    </div>

</div>

<?= $this->Form->create($recipe); ?>
<div class="row">
    <?php
        
            echo '<div class="col-lg-12 form-group">';
                echo $this->Form->control('title', ['required' => true, 'class' => 'form-control']);
            echo '</div>';
            echo '<div class="col-lg-12 form-group">';
                echo $this->Form->control('description', ['rows' => '6', 'required' => true, 'class' => 'form-control']);
            echo '</div>';
        echo '</div>';
        echo '<div class="row">';
            echo '<div class="col-lg-12">';
                echo '<h3>Ingredients</h3>';
            echo '</div>';
            echo '<div class="col-lg-6 form-group">';
                echo $this->Form->label('ingredientDescription', 'Name');
                echo $this->Form->text('ingredientDescription', 
                ['class' => 'form-control add-ingredient-input', 'id' => 'ingredientDescription', 'onChange' => 'handleAddIngredientBtn()']);
            echo '</div>';
            echo '<div class="col-lg-2 form-group">';
                echo $this->Form->label('ingredientAmount', 'Amount');
                echo $this->Form->number('ingredientAmount', 
                ['class' => 'form-control add-ingredient-input', 'min' => '0', 'max' => '10000', 'id' => 'ingredientAmount', 'onChange' => 'handleAddIngredientBtn()']);
            echo '</div>';
            echo '<div class="col-lg-1 form-group">';
                echo $this->Form->label('ingredientUnit', 'Unit');
                echo $this->Form->text('ingredientUnit', ['class' => 
                'form-control add-ingredient-input', 'list' => 'units', 'id' => 'ingredientUnit', 'onChange' => 'handleAddIngredientBtn()']);
                echo '<datalist id="units">';
                foreach ($units as $unit) {
                    echo '<option value="' . h($unit->description) . '">';
                }
                echo '</datalist>';
            echo '</div>';
            echo '<div class="col-lg-2 form-group d-flex align-items-end">';
                echo $this->Form->button('Add Ingredient', 
                ['type' => 'button', 'class' => 'btn btn-secondary', 'disabled' => true, 'id' => 'addIngredientBtn', 'onClick' => 'addIngredientToList()']);
            echo '</div>';
            echo '<div class="col-lg-9 form-group">';
                echo $this->Form->control('ingredients', 
                ['type' => 'select', 'class' => 'form-control', 'required' => true, 'multiple' => true, 'id' => 'ingredientsList', 'onChange' => 'handleRemoveIngredientBtn()']);
            echo '</div>';
            echo '<div class="col-lg-2 form-group d-flex align-items-end">';
                echo $this->Form->button('Remove', 
                ['type' => 'button', 'class' => 'btn btn-danger', 'disabled' => true, 'id' => 'removeIngredientBtn', 'onClick' => 'removeIngredientFromList()']);
            echo '</div>';
        echo '</div>';
        echo '<div class="row">';
            echo '<div class="col-lg-12">';
            echo $this->Form->button(('Save'), ['class' => 'btn btn-primary', 'onClick' => 'selectAllIngredients()']);
            echo '</div>';
        echo '</div>';
    ?>
</div>
<?= $this->Form->end() ?>