<?php declare(strict_types = 1);
namespace noxkiwi\cookbook\Translator;

use Exception;
use noxkiwi\core\ErrorHandler;
use noxkiwi\database\Database;
use noxkiwi\database\Exception\DatabaseException;
use noxkiwi\cookbook\Model\TranslationModel;
use noxkiwi\translator\Translator;
use const E_USER_NOTICE;

/**
 * I am the Translator that uses JSON files.
 *
 * @package      noxkiwi\translator\Translator
 * @author       Jan Nox <jan@nox.kiwi>
 * @license      https://nox.kiwi/license
 * @copyright    2021 noxkiwi
 * @version      1.0.0
 * @link         https://nox.kiwi/
 */
final class CookbookTranslator extends Translator
{
    /**
     * @inheritDoc
     * @throws \noxkiwi\singleton\Exception\SingletonException
     * @return array
     */
    public function getKeys(): array
    {
        $query   = <<<MYSQL
SELECT `translation`.`translation_key` FROM `translation`;
MYSQL;
        $results = [];
        try {
            $database = Database::getInstance();
            $database->read($query);
            $results = $database->getResult();
        } catch (DatabaseException $exception) {
            ErrorHandler::handleException($exception, E_USER_NOTICE);
        }
        $ret = [];
        foreach ($results as $result) {
            $ret[] = $result['Name'];
        }

        return $ret;
    }

    /**
     * @inheritDoc
     */
    public function getLanguages(): array
    {
        return [
            self::LANGUAGE_DE_DE,
            self::LANGUAGE_EN_US
        ];
    }

    /**
     * @inheritDoc
     */
    protected function getTranslation(string $key): string
    {
        try {
            $translationModel = TranslationModel::getInstance();
            $translation      = $translationModel->load($key);
            return $translation['translation_german'] ?? $key;
        } catch (Exception $exception) {
            return 'FAULTED' . $key . $exception->getMessage();
        }
    }
}
