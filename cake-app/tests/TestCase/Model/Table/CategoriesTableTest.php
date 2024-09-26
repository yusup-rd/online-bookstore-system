<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CategoriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CategoriesTable Test Case
 */
class CategoriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CategoriesTable
     */
    public $Categories;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Categories',
        'app.Books',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Categories') ? [] : ['className' => CategoriesTable::class];
        $this->Categories = TableRegistry::getTableLocator()->get('Categories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Categories);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->assertInstanceOf(CategoriesTable::class, $this->Categories);
        $this->assertEquals('categories', $this->Categories->getTable());
        $this->assertTrue($this->Categories->hasBehavior('Timestamp'));
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $validator = $this->Categories->getValidator('default');

        $this->assertNotEmpty($validator->field('name'));
        $this->assertNotEmpty($validator->field('status'));
    }

    /**
     * Test findActiveCategories method.
     *
     * @return void
     */
    public function testFindActiveCategories()
    {
        $this->Categories->save($this->Categories->newEntity([
            'name' => 'Active Category',
            'status' => true,
        ]));

        $this->Categories->save($this->Categories->newEntity([
            'name' => 'Inactive Category',
            'status' => false,
        ]));

        // Fetch active categories
        $query = $this->Categories->find('activeCategories');
        $result = $query->toArray();

        // Extract category names from the result
        $categoryNames = array_values($result);

        $this->assertContains('Active Category', $categoryNames, 'The active category should be "Active Category".');
        $this->assertNotContains('Inactive Category', $categoryNames, 'The inactive category should not be present in the results.');
    }
}
