<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StatsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StatsTable Test Case
 */
class StatsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\StatsTable
     */
    public $Stats;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.stats',
        'app.vendors',
        'app.vendors_mxs',
        'app.domains',
        'app.domains_records',
        'app.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Stats') ? [] : ['className' => StatsTable::class];
        $this->Stats = TableRegistry::get('Stats', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Stats);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
