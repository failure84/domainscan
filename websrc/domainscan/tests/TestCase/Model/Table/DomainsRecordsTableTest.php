<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DomainsRecordsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DomainsRecordsTable Test Case
 */
class DomainsRecordsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DomainsRecordsTable
     */
    public $DomainsRecords;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.DomainsRecords',
        'app.Domains',
        'app.Vendors',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DomainsRecords') ? [] : ['className' => DomainsRecordsTable::class];
        $this->DomainsRecords = TableRegistry::getTableLocator()->get('DomainsRecords', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DomainsRecords);

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
