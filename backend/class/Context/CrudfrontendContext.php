<?php declare(strict_types = 1);
namespace noxkiwi\cookbook\Context;

use noxkiwi\crud\Context\CrudfrontendContext as BaseCrudFrontendContext;

/**
 * I am the frontend Context for the CRUD manager.
 *
 * @package      noxkiwi\nlfwadmin\Context
 * @uses         \noxkiwi\nlfwadmin\Model\WorkflowModel
 * @uses         \noxkiwi\nlfwadmin\Model\ListModel
 * @uses         \noxkiwi\nlfwadmin\Model\ActionModel
 * @uses         \noxkiwi\nlfwadmin\Model\FieldModel
 * @author       Jan Nox <jan@nox.kiwi>
 * @license      https://nox.kiwi/license
 * @copyright    2021 noxkiwi
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
