<?php declare(strict_types = 1);
namespace noxkiwi\cookbook;

use noxkiwi\cookbook\Model\IngredientModel;
use noxkiwi\core\Constants\Mvc;
use noxkiwi\core\Helper\LinkHelper;
use noxkiwi\translator\Translator;

/** @var \noxkiwi\core\Response $data */
$ingredients       = IngredientModel::getInstance()->search();
$t                 = Translator::getInstance();
$submit = LinkHelper::makeUrl([Mvc::CONTEXT=>'creator', Mvc::VIEW=>'create', 'F00'=>'baz']);
$ingredientOptions = '';
foreach ($ingredients as $ingredient) {
    $ingredientOptions .= <<<HTML
<option value="{$ingredient['ingredient_id']}" label="{$t->translate($ingredient['translation_name'])}" data-unit="{$t->translate($ingredient['ingredient_unit'])}">{$t->translate($ingredient['translation_name'])}</option>
HTML;
}
?>
<h2><?=$t->translate('CREATE_RECIPE')?></h2>
<form id="createForm">
    <div class="mb-3">
        <label for="recipe_title" class="form-label"><?=$t->translate('RECIPE_TITLE')?></label>
        <input type="text" class="form-control" name="recipe_title" id="recipe_title" placeholder="<?=$t->translate('RECIPE_TITLE')?>">
    </div>
    <div class="mb-3">
        <label for="recipe_skill" class="form-label"><?=$t->translate('RECIPE_SKILL')?></label>
        <input min="1" max="5" type="number" class="form-control" name="recipe_skill" id="recipe_skill" placeholder="<?=$t->translate('RECIPE_SKILL')?>">
    </div>
    <div class="mb-3">
        <label for="recipe_time" class="form-label"><?=$t->translate('RECIPE_TIME')?></label>
        <input min="1" max="300" type="number" class="form-control" name="recipe_time" id="recipe_time" placeholder="<?=$t->translate('RECIPE_TIME')?>">
    </div>
    <div class="mb-3">
        <label for="recipe_description" class="form-label"><?=$t->translate('RECIPE_DESCRIPTION')?></label>
        <textarea class="form-control" name="recipe_description" id="recipe_description" placeholder="<?=$t->translate('RECIPE_DESCRIPTION')?>"></textarea>
    </div>

    <div class="mb-3">
        <label for="recipe_ingredients" class="form-label"><?=$t->translate('INGREDIENTS')?></label>
        <table class="table table-sm table-striped">
            <thead>
            <tr>
                <th colspan="2"><a id="btnAddIngredient" class="btn btn-sm btn-success" title="<?=$t->translate('ADD_INGREDIENT')?>">+</a> <?=$t->translate('INGREDIENT')?></th>
                <th><?=$t->translate('AMOUNT')?></th>
            </tr>
            </thead>
            <tbody id="ingredientsBody">
            <tr id="ingredientTemplate" style="display:none;">
                <td>
                    <a title="<?=$t->translate('REMOVE_INGREDIENT')?>" class="btnRemoveIngredient btn btn-sm btn-danger">X</a>
                </td>
                <td>
                    <select class="selIngredient form-control"><?= $ingredientOptions ?></select>
                </td>
                <td>
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" placeholder="Menge" aria-label="Username" min="1" aria-describedby="basic-addon1">
                        <span class="ingredientUnit input-group-text">@</span>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <input type="submit">
</form>

<script>
    $("document").ready(function () {
        // WILL ADD INGREDIENT!
        $("#btnAddIngredient").click(function () {
            let templateRow = $("#ingredientTemplate"),
                tableBody   = templateRow.parent("tbody"),
                newRow      = templateRow.clone();

            // Remove the ID!
            newRow.attr("id", null);
            tableBody.append(newRow);
            newRow.show();
            // Trigger the change event on the ingredient to show the correct unit
            $(newRow).find(".selIngredient").trigger("change");
        });
        // WILL CHANGE THE UNIT IF INGREDIENT CHANGED
        $("body").delegate(".selIngredient", "change", function () {
            let row      = $(this).parents("tr"),
                unitText = $(this).find("option:selected").attr("data-unit"),
                unit     = $(row).find(".ingredientUnit");
            unit.html(unitText);
        });
        // WILL REMOVE AN INGREDIENT!
        $("body").delegate(".btnRemoveIngredient", "click", function () {
            let row = $(this).parents("tr");
            row.remove();
        });
        // WILL SUBMIT!!
        $("#createForm").submit(function () {
            // LOCK FORM
            $(this).find('input,select,textarea').attr('disabled', 'disabled').attr('readonly', 'readonly');
            let title       = $(this).find("input[name=\"recipe_title\"]").val(),
                skill       = parseInt($(this).find("input[name=\"recipe_skill\"]").val()),
                time        = parseInt($(this).find("input[name=\"recipe_time\"]").val()),
                description = $(this).find("textarea[name=\"recipe_description\"]").val(),
                ingredients = [];

            $("#ingredientsBody").find("tr").not("#ingredientTemplate").each(function () {
                let ingredientId = parseInt($(this).find("select").val()),
                    amount       = parseFloat($(this).find("input").val());
                ingredients.push({
                    ingredient_id : ingredientId,
                    amount        : amount
                });
            });
            let data = {
                time        : time,
                skill       : skill,
                name        : title,
                description : description,
                ingredients : ingredients,
                F00 : 'baz'
            };

            $.ajax({
                async       : true,
                url         : "<?=$submit?>",
                data        : JSON.stringify(data),
                cache       : false,
                contentType : false,
                method      : "POST",
                dataType    : "json",
                processData : false,
                success     : function (data) {
                    window.location.href = data.recipe_url;
                },
                complete    : function () {
                }
            });
            // UNLOCK FORM
            $(this).find('input,select,textarea').attr('disabled', null).attr('readonly', null);
            return false;
        });
    });
</script>