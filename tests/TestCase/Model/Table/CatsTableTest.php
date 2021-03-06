<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CatsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CatsTable Test Case
 */
class CatsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CatsTable
     */
    public $Cats;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.cats',
        'app.litters',
        'app.adopters',
        'app.fosters',
        'app.files',
        'app.cat_histories',
        'app.adoption_events',
        'app.cats_adoption_events',
        'app.tags',
        'app.tags_cats'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Cats') ? [] : ['className' => 'App\Model\Table\CatsTable'];
        $this->Cats = TableRegistry::get('Cats', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Cats);

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
