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
                'recipe_id' => 1,
                'ingredient' => 'Lorem ipsum dolor sit amet',
                'created' => '2021-10-29 01:32:15',
                'modified' => '2021-10-29 01:32:15',
            ],
        ];
        parent::init();
    }
}
