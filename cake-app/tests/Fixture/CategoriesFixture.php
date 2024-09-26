<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CategoriesFixture
 */
class CategoriesFixture extends TestFixture
{
    /**
     * Import
     *
     * @var array
     */
    public $import = ['table' => 'categories'];
    // @codingStandardsIgnoreEnd
    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'name' => 'Comedy',
                'status' => 1,
                'deleted' => null,
                'created' => '2024-07-24 11:02:20',
                'modified' => '2024-07-24 11:02:20',
            ],
            [
                'id' => 2,
                'name' => 'Romance',
                'status' => 1,
                'deleted' => null,
                'created' => '2024-07-24 11:02:20',
                'modified' => '2024-07-24 11:02:20',
            ],
            [
                'id' => 3,
                'name' => 'Horror',
                'status' => 0,
                'deleted' => null,
                'created' => '2024-07-24 11:02:20',
                'modified' => '2024-07-24 11:02:20',
            ],
        ];
        parent::init();
    }
}
