<?php declare(strict_types = 1);
namespace noxkiwi\cookbook\Model;

use noxkiwi\dataabstraction\Model;

/**
 * I am the storage for Ingredients for Recipes.
 *
 * A Recipe may contain more than one single Ingredient. So we need a 1<->n relation here.
 *
 * This MAY also be stored in MySQL 5.7 `json` fields. But dataabstraction is currently incapable of managing these.
 *
 * @package      noxkiwi\cookbook\Model
 * @author       Jan Nox <jan@nox.kiwi>
 * @license      https://nox.kiwi/license
 * @copyright    2022 noxkiwi
 * @version      1.0.0
 * @link         https://nox.kiwi/
 */
final class RecipeIngredientModel extends Model
{
    public const TABLE = 'recipe_ingredient';

}
