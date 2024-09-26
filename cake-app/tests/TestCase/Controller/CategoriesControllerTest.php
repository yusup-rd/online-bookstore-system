<?php
namespace App\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\CategoriesController Test Case
 *
 * @uses \App\Controller\CategoriesController
 */
class CategoriesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Categories',
        'app.Books',
        'app.BooksCategories',
    ];

    /**
     * Set up method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->Categories = TableRegistry::getTableLocator()->get('Categories');
    }

    /**
     * Test index method
     *
     * @return void
     * @throws \PHPUnit\Exception
     */
    public function testIndex()
    {
        // Test for Admin accessing category index
        $this->session(['Auth.User' => ['role' => 'admin', 'id' => 1]]);
        $this->get('/categories');
        $this->assertResponseOk();

        // Test for Assistant accessing category index
        $this->session(['Auth.User' => ['role' => 'assistant', 'id' => 2]]);
        $this->get('/categories');
        $this->assertResponseOk();

        // Test for Publisher, not allowed to access category index
        $this->session(['Auth.User' => ['role' => 'publisher', 'id' => 3]]);
        $this->get('/categories');
        $this->assertResponseCode(302);
    }

    /**
     * Test view method
     *
     * @return void
     * @throws \PHPUnit\Exception
     */
    public function testView()
    {
        // Admin should be able to view categories
        $this->session(['Auth.User' => ['id' => 1, 'role' => 'admin']]);
        $this->get('/categories/view/1');
        $this->assertResponseOk();

        // Assistant should be able to view categories
        $this->session(['Auth.User' => ['id' => 2, 'role' => 'assistant']]);
        $this->get('/categories/view/1');
        $this->assertResponseOk();

        // Publisher should not be able to view categories
        $this->session(['Auth.User' => ['id' => 3, 'role' => 'publisher']]);
        $this->get('/categories/view/1');
        $this->assertResponseCode(302);
    }

    /**
     * Test add method
     *
     * @return void
     * @throws \PHPUnit\Exception
     */
    public function testAdd()
    {
        // Admin can add new category
        $this->session(['Auth' => ['role' => 'admin', 'id' => 1]]);
        $this->post('/categories/add', [
            'name' => 'Admin Added Category',
            'status' => 1,
        ]);
        $this->assertResponseSuccess();

        // Assistant can add new category
        $this->session(['Auth' => ['role' => 'assistant', 'id' => 2]]);
        $this->post('/categories/add', [
            'name' => 'Assistant Added Category',
            'status' => 1,
        ]);
        $this->assertResponseSuccess();

        // Publisher cannot add new category
        $this->session(['Auth' => ['role' => 'publisher', 'id' => 3]]);
        $this->post('/categories/add', [
            'name' => 'Publisher Added Category',
            'status' => 1,
        ]);
        $this->assertResponseCode(302);
    }

    /**
     * Test edit method
     *
     * @return void
     * @throws \PHPUnit\Exception
     */
    public function testEdit()
    {
        // Admin user
        $this->session(['Auth.User' => ['role' => 'admin', 'id' => 1]]);
        $this->post('/categories/add', [
            'name' => 'Category to Edit',
            'status' => 1,
        ]);

        // Fetch the last inserted category from the database
        $category = $this->getTableLocator()->get('Categories')->find()->order(['id' => 'DESC'])->first();
        $categoryId = $category ? $category->id : null;

        // Ensure the category was created
        $this->assertNotEmpty($category);
        $this->assertNotNull($this->Categories->get($categoryId));

        // Test editing by Admin
        $this->post("/categories/edit/$categoryId", [
            'name' => 'Edited by Admin',
            'status' => 1,
        ]);
        $this->assertResponseSuccess();
        $editedCategory = $this->Categories->get($categoryId);
        $this->assertEquals('Edited by Admin', $editedCategory->name);
    }

    /**
     * Test delete method
     *
     * @return void
     * @throws \PHPUnit\Exception
     */
    public function testDelete()
    {
        // Admin should be able to delete category
        $this->session(['Auth.User' => ['id' => 1, 'role' => 'admin']]);
        $this->delete('/categories/delete/1');
        $this->assertResponseSuccess();
        $this->assertRedirect(['action' => 'index']);
        $category = $this->Categories->find()->where(['id' => 1])->first();
        $this->assertEmpty($category);

        // Assistant should be able to delete category
        $this->session(['Auth.User' => ['id' => 2, 'role' => 'assistant']]);
        $this->delete('/categories/delete/2');
        $this->assertResponseSuccess();
        $this->assertRedirect(['action' => 'index']);
        $category = $this->Categories->find()->where(['id' => 2])->first();
        $this->assertEmpty($category);

        // Publisher should not be able to delete categories
        $this->session(['Auth' => ['id' => 3, 'role' => 'publisher']]);
        $this->delete('/categories/delete/3');
        $this->assertResponseCode(302);
    }
}
