<?php declare(strict_types = 1);
namespace noxkiwi\cookbook;

use noxkiwi\core\Helper\FrontendHelper;
use noxkiwi\core\Path;

/** @var \noxkiwi\core\Response $data */


$recipes = '';
foreach($data->get('recipes') as $recipe) {
    $recipes .= FrontendHelper::parseFile(Path::getInheritedPath('/frontend/element/recipe/searchresult.php'), $recipe);
}

echo $recipes;
