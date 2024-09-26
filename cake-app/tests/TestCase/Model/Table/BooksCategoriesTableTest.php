<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BooksCategoriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BooksCategoriesTable Test Case
 */
class BooksCategoriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BooksCategoriesTable
     */
    public $BooksCategories;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.BooksCategories',
        'app.Books',
        'app.Categories',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('BooksCategories') ? [] : ['className' => BooksCategoriesTable::class];
        $this->BooksCategories = TableRegistry::getTableLocator()->get('BooksCategories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BooksCategories);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->assertInstanceOf(BooksCategoriesTable::class, $this->BooksCategories);
        $this->assertEquals('books_categories', $this->BooksCategories->getTable());
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $validator = $this->BooksCategories->getValidator('default');

        $this->assertEmpty($validator->field('user_id'));
        $this->assertEmpty($validator->field('category_id'));
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        // Attempt to relate a book-category with a valid user_id and category_id
        $validBooksCategories = $this->BooksCategories->newEntity([
            'book_id' => 1,
            'user_id' => 3,
            'category_id' => 3,
        ]);

        $result = $this->BooksCategories->save($validBooksCategories);
        $this->assertNotFalse($result, 'Valid book category should be saved');

        // Attempt to save a book-category with an invalid user_id and category_id
        $validBooksCategories = $this->BooksCategories->newEntity([
            'user_id' => 999,
            'category_id' => 999,
        ]);

        $result = $this->BooksCategories->save($validBooksCategories);
        $this->assertFalse($result, 'Invalid book category should not be saved');
    }
}
