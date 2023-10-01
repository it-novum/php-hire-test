<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * IngredientsFixture
 */
class IngredientsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'description' => 'Lorem ipsum dolor sit amet',
                'amount' => 1,
                'unit' => 'Lorem ipsum dolor sit amet',
                'recipe_id' => 1,
                'created' => '2023-09-28 18:29:16',
                'modified' => '2023-09-28 18:29:16',
            ],
        ];
        parent::init();
    }
}
