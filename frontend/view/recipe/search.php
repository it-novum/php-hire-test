<?php declare(strict_types = 1);
namespace noxkiwi\cookbook;

use noxkiwi\core\Helper\FrontendHelper;
use noxkiwi\core\Path;
use noxkiwi\translator\Translator;

/** @var \noxkiwi\core\Response $data */
$query = $data->get('query');
$count = $data->get('count');
$recipes = '';
foreach ($data->get('recipes', []) as $recipe) {
    $recipes .= FrontendHelper::parseFile(Path::getInheritedPath('/frontend/element/recipe/searchresult.php'), $recipe);
}
$t = Translator::getInstance();
echo <<<HTML
{$t->translate('SEARCH', ['count' => $count, 'query' => $query])}
<hr />
$recipes
HTML;
