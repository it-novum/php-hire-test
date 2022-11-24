<?php declare(strict_types = 1);
namespace noxkiwi\cookbook\Model;

use noxkiwi\dataabstraction\Model;

/**
 * I am the storage for ingredient types.
 *
 * These are among others fruit, vegetables, herbs or spices.
 *
 * @package      noxkiwi\cookbook\Model
 * @author       Jan Nox <jan@nox.kiwi>
 * @license      https://nox.kiwi/license
 * @copyright    2022 noxkiwi
 * @version      1.0.0
 * @link         https://nox.kiwi/
 */
final class IngredientTypeModel extends Model
{
    public const TABLE = 'ingredient_type';

}
