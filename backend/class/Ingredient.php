<?php declare(strict_types = 1);
namespace noxkiwi\cookbook;

use noxkiwi\translator\Traits\TranslatorTrait;
use Stringable;

/**
 * I am the storage for translations.
 *
 * @package      noxkiwi\dataabstraction\Model
 * @author       Jan Nox <jan@nox.kiwi>
 * @license      https://nox.kiwi/license
 * @copyright    2022 noxkiwi
 * @version      1.0.0
 * @link         https://nox.kiwi/
 */
final class Ingredient implements Stringable
{
    use TranslatorTrait;

    public string $name;
    public float  $amount;
    public string $unit;

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return <<<HTML
<tr>
    <td>
        {$this->translate($this->name)}
    </td>
    <td style="text-align: right;">
        $this->amount {$this->translate($this->unit)}
    </td>
</tr>
HTML;
    }
}
