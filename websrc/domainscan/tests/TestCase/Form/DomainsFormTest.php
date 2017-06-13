<?php
namespace App\Test\TestCase\Form;

use App\Form\DomainsForm;
use Cake\TestSuite\TestCase;

/**
 * App\Form\DomainsForm Test Case
 */
class DomainsFormTest extends TestCase
{

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Domains = new DomainsForm();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Domains);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
