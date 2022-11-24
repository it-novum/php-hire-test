<?php declare(strict_types = 1);
namespace noxkiwi\cookbook\Context;

use noxkiwi\core\Context\ResourceContext as BaseResourceContext;

/**
 * I am the Resource Context
 *
 * @package      noxkiwi\cookbook\Context
 * @author       Jan Nox <jan@nox.kiwi>
 * @license      https://nox.kiwi/license
 * @copyright    2018 noxkiwi
 * @version      1.0.0
 * @link         https://nox.kiwi/
 */
final class ResourceContext extends BaseResourceContext
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
