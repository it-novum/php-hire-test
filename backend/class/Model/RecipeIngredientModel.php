<?php declare(strict_types = 1);
namespace noxkiwi\cookbook\Model;

use noxkiwi\dataabstraction\Model;

/**
 * I am the storage for Recipes.
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
