<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LogsFixture
 */
class LogsFixture extends TestFixture
{
    /**
     * Import
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $import = ['table' => 'logs'];

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
                'url' => '/users',
                'ip_address' => '127.0.0.1',
                'user_id' => 1,
                'timestamp' => 1722230382,
            ],
        ];
        parent::init();
    }
}
