<?php declare(strict_types = 1);
namespace noxkiwi\cookbook;

use noxkiwi\core\Constants\Mvc;
use noxkiwi\core\Helper\FrontendHelper;
use noxkiwi\core\Helper\LinkHelper;
use noxkiwi\core\Path;
use noxkiwi\translator\Translator;

/** @var \noxkiwi\core\Response $data */


$recipes = '';
foreach($data->get('recipes') as $recipe) {
    $recipes .= FrontendHelper::parseFile(Path::getInheritedPath('/frontend/element/recipe/searchresult.php'), $recipe);
}
$urlLatest  = LinkHelper::makeUrl([Mvc::CONTEXT=>'recipe', Mvc::VIEW=>'list', 'o'=>'LATEST']);
$urlFastest = LinkHelper::makeUrl([Mvc::CONTEXT=>'recipe', Mvc::VIEW=>'list', 'o'=>'FASTEST']);
$urlEasiest = LinkHelper::makeUrl([Mvc::CONTEXT=>'recipe', Mvc::VIEW=>'list', 'o'=>'EASIEST']);
$urlName    = LinkHelper::makeUrl([Mvc::CONTEXT=>'recipe', Mvc::VIEW=>'list', 'o'=>'NAME']);
$t          = Translator::getInstance();
echo <<<HTML
<div class="btn-group" role="group" aria-label="Basic example">
  <a type="button" class="btn btn-secondary active" href="$urlLatest">{$t->translate('LATEST')}</a>
  <a type="button" class="btn btn-secondary active" href="$urlFastest">{$t->translate('FASTEST')}</a>
  <a type="button" class="btn btn-secondary active" href="$urlEasiest">{$t->translate('EASIEST')}</a>
  <a type="button" class="btn btn-secondary active" href="$urlName">{$t->translate('NAME')}</a>
</div>
$recipes
HTML;

