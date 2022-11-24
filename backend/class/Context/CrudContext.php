<?php declare(strict_types = 1);
namespace noxkiwi\cookbook\Context;

use noxkiwi\crud\Context\CrudContext as BaseCrudContext;

/**
 * I am the Context that manages data transfer between Crud front-end and Crud back-end.
 *
 * @package      noxkiwi\cookbook\Context
 * @author       Jan Nox <jan@nox.kiwi>
 * @license      https://nox.kiwi/license
 * @copyright    2022 noxkiwi
 * @version      1.0.0
 * @link         https://nox.kiwi/
 */
final class CrudContext extends BaseCrudContext
{
    /**
     * @inheritDoc
     */
    public function isAllowed(): bool
    {
        parent::isAllowed();

        return true;
    }
}
