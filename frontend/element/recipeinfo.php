<?php declare(strict_types = 1);
namespace noxkiwi\cookbook;

use noxkiwi\translator\Translator;

/** @var \noxkiwi\cookbook\Recipe $data */
$t      = Translator::getInstance();
$stars  = str_repeat('🌟', (int)ceil($data->rating)) . str_repeat('◼', 5-(int)ceil($data->rating));
$spoons = str_repeat('🔪', $data->skill) . str_repeat('◼', 5-$data->skill);
echo <<<HTML
<h3>{$t->translate('INFO')}</h3>
<table class="table table-sm table-striped">
    <tbody>
        <tr>
            <th>{$t->translate('DURATION')}</th>
            <td>$data->duration min</td>
        </tr>
        <tr>
            <th>{$t->translate('VIEWS')}</th>
            <td>$data->views</td>
        </tr>
        <tr>
            <th>{$t->translate('RATING')}</th>
            <td>$stars</td>
        </tr>
        <tr>
            <th>{$t->translate('SKILL')}</th>
            <td>$spoons</td>
        </tr>
        <tr>
            <th>{$t->translate('CREATED')}</th>
            <td>{$data->created->format($t->translate('DATE_TIME_FORMAT'))}</td>
        </tr>
    </tbody>
</table>
HTML;
