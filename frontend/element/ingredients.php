<?php declare(strict_types = 1);
namespace noxkiwi\cookbook;

use noxkiwi\core\Response;
use noxkiwi\translator\Translator;

/** @var \noxkiwi\cookbook\Recipe $data */
$ingredients = implode(' ', $data->ingredients);
$multiplier  = Response::getInstance()->get('multiplier');
$t           = Translator::getInstance();
echo <<<HTML
<h3>{$t->translate('INGREDIENTS')}</h3>
<table class="table table-sm table-striped">
    <thead>
        <tr>
            <th>{$t->translate('INGREDIENT')}</th>
            <th>{$t->translate('AMOUNT')}</th>
        </tr>
    </thead>
    <tbody>
        $ingredients
        <tr>
            <td colspan="2">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">{$t->translate('PORTIONS')}: </span>
                    <input id="inpRecalc" value="$multiplier" type="number" class="form-control" placeholder="{$t->translate('PORTIONS')}" aria-label="{$t->translate('PORTIONS')}">
                    <a class="btnRecalc btn btn-success input-group-text" id="basic-addon1">{$t->translate('RECALCULATE')}</a>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<script>
$(document).ready(function() {
    $('.btnRecalc').click(function() {
        let val = parseFloat($('#inpRecalc').val());
        
        window.location.href = window.location.href + "&m="+ val;
    });
});
</script>
HTML;
