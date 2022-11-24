<?php declare(strict_types = 1);
namespace noxkiwi\cookbook;

use noxkiwi\core\Helper\FrontendHelper;
use noxkiwi\core\Path;
use noxkiwi\translator\Translator;

/** @var \noxkiwi\core\Response $data */

/** @var \noxkiwi\cookbook\Recipe $recipe */
$recipe = $data->get('recipe');

$t = Translator::getInstance();

/** @var \noxkiwi\cookbook\Recipe $data */
$ingredientList = FrontendHelper::parseFile(Path::getInheritedPath('frontend/element/ingredients.php'), $recipe);
$recipeInfo     = FrontendHelper::parseFile(Path::getInheritedPath('frontend/element/recipeinfo.php'), $recipe);
echo <<<HTML
<h1>{$t->translate($recipe->name)}</h1>
<div class="row">
    <div class="col-lg-4">
        <h3>{$t->translate('photo')}</h3>
        <img width="100%" src="https://placekitten.com/g/400/300">
        <hr />
        $recipeInfo
    </div>
    <div class="col-lg-6">
        $ingredientList
    </div>
</div>
<hr />

<h3>{$t->translate('preparation')}</h3>
<p>
    {$t->translate($recipe->description)}
</p>
HTML;
