<?php declare(strict_types = 1);
namespace noxkiwi\cookbook\Context;

use noxkiwi\crud\Context\CrudfrontendContext as BaseCrudFrontendContext;

/**
 * I am the frontend Context for the CRUD manager.
 *
 * @package      noxkiwi\cookbook\Context
 * @author       Jan Nox <jan@nox.kiwi>
 * @license      https://nox.kiwi/license
 * @copyright    2022 noxkiwi
 * @version      1.0.0
 * @link         https://nox.kiwi/
 *
 */
final class CrudfrontendContext extends BaseCrudFrontendContext
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
