<?php declare(strict_types = 1);
namespace noxkiwi\cookbook;

use noxkiwi\core\Constants\Mvc;
use noxkiwi\core\Helper\FrontendHelper;
use noxkiwi\core\Helper\LinkHelper;
use noxkiwi\core\Path;
use noxkiwi\translator\Translator;

/** @var \noxkiwi\cookbook\Recipe $data */
$url = LinkHelper::makeUrl([Mvc::CONTEXT => 'recipe', Mvc::VIEW => 'recipe', 'recipe_id' => $data->recipeId]);
$t = Translator::getInstance();

$recipeInfo     = FrontendHelper::parseFile(Path::getInheritedPath('frontend/element/recipeinfo.php'), $data);
echo <<<HTML
<div class="col-md-12">
    <div class="row">
        <div class="col-md-3">
            <a href="$url"><img src="https://placekitten.com/g/300/300"></a>
        </div>
        <div class="col-md-3">
            <h3><a href="$url">{$t->translate($data->name)}</a></h3>
            <hr />
            $recipeInfo
        </div>
    </div>
</div>
HTML;
