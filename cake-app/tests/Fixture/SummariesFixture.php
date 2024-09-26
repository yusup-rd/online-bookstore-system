<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SummariesFixture
 */
class SummariesFixture extends TestFixture
{
    /**
     * Import
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $import = ['table' => 'summaries'];
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
                'search_id' => 1,
                'created' => '2024-08-02 03:30:26',
            ],
            [
                'id' => 2,
                'search_id' => 1,
                'created' => '2024-08-03 03:30:26',
            ],
            [
                'id' => 3,
                'search_id' => 5,
                'created' => '2024-08-04 03:30:26',
            ],
            [
                'id' => 4,
                'search_id' => 1,
                'created' => '2024-08-05 03:30:26',
            ],
            [
                'id' => 5,
                'search_id' => 2,
                'created' => '2024-08-06 03:30:26',
            ],
            [
                'id' => 6,
                'search_id' => 2,
                'created' => '2024-08-07 03:30:26',
            ],
            [
                'id' => 7,
                'search_id' => 3,
                'created' => '2024-08-08 03:30:26',
            ],
            [
                'id' => 8,
                'search_id' => 4,
                'created' => '2024-08-09 03:30:26',
            ],
        ];
        parent::init();
    }
}
