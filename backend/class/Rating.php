<?php declare(strict_types = 1);
namespace noxkiwi\cookbook;

use DateTime;

/**
 * I am a Rating for a Recipe.
 *
 * @package      noxkiwi\cookbook
 * @author       Jan Nox <jan@nox.kiwi>
 * @license      https://nox.kiwi/license
 * @copyright    2022 noxkiwi
 * @version      1.0.0
 * @link         https://nox.kiwi/
 */
final class Rating
{
    public DateTime $created;
    public string   $comment;
    public int      $stars;
}
