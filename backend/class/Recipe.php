<?php declare(strict_types = 1);
namespace noxkiwi\cookbook;

use DateTime;

/**
 * I am the Recipe Object.
 *
 * @package      noxkiwi\cookbook
 * @author       Jan Nox <jan@nox.kiwi>
 * @license      https://nox.kiwi/license
 * @copyright    2022 noxkiwi
 * @version      1.0.0
 * @link         https://nox.kiwi/
 */
final class Recipe
{
    public int      $recipeId;
    public string   $name;
    public string   $description;
    public float    $multiplier;
    public float    $rating;
    public int      $duration;
    public int      $views;
    public int      $skill;
    public DateTime $created;
    /** @var \noxkiwi\cookbook\Ingredient[] */
    public array $ingredients;
    /** @var \noxkiwi\cookbook\Rating[] */
    public array $ratings;
}
