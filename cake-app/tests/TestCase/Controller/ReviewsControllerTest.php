<?php
namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\ReviewsController Test Case
 *
 * @uses \App\Controller\ReviewsController
 */
class ReviewsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Reviews',
        'app.Users',
        'app.Books',
    ];

    /**
     * Test index method
     *
     * @return void
     * @throws \PHPUnit\Exception
     */
    public function testIndex()
    {
        $this->session(['Auth.User' => ['id' => 1, 'role' => 'admin']]);

        $this->get('/reviews');
        $this->assertResponseOk();
        $this->assertResponseContains('Reviews');
    }

    /**
     * Test view method
     *
     * @return void
     * @throws \PHPUnit\Exception
     */
    public function testView()
    {
        $this->session(['Auth.User' => ['id' => 1, 'role' => 'admin']]);

        $this->get('/reviews/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('Review');
        $this->assertResponseContains('User');
        $this->assertResponseContains('Book');
    }

    /**
     * Test add method
     *
     * @return void
     * @throws \PHPUnit\Exception
     */
    public function testAdd()
    {
        $this->session(['Auth.User' => ['id' => 6, 'role' => 'member']]);

        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $data = [
            'rating' => 5,
            'comment' => 'Excellent book!',
            'user_id' => 6,
            'book_id' => 1,
        ];

        $this->post('/reviews/add', $data);
        $this->assertResponseSuccess();
        $reviews = $this->getTableLocator()->get('Reviews');
        $query = $reviews->find()->where(['comment' => 'Excellent book!']);
        $this->assertEquals(1, $query->count());
    }

    /**
     * Test edit method
     *
     * @return void
     * @throws \PHPUnit\Exception
     */
    public function testEdit()
    {
        $this->session(['Auth.User' => ['id' => 6, 'role' => 'member']]);

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $data = [
            'rating' => 4,
            'comment' => 'Updated comment',
        ];
        $this->put('/reviews/edit/1', $data);
        $this->assertResponseSuccess();
        $reviews = $this->getTableLocator()->get('Reviews');
        $query = $reviews->find()->where(['id' => 1]);
        $this->assertEquals('Updated comment', $query->first()->comment);
    }

    /**
     * Test delete method
     *
     * @return void
     * @throws \PHPUnit\Exception
     */
    public function testDelete()
    {
        // Member
        $this->session(['Auth.User' => ['id' => 6, 'role' => 'member']]);
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->delete('/reviews/delete/1');
        $this->assertResponseSuccess();
        $reviews = $this->getTableLocator()->get('Reviews');
        $query = $reviews->find()->where(['id' => 1]);
        $this->assertEquals(0, $query->count());

        // Attempt to delete a review that does not belong to the user
        $this->delete('/reviews/delete/2');
        $this->assertResponseCode(302);

        // Admin
        $this->session(['Auth.User' => ['id' => 1, 'role' => 'admin']]);
        $this->delete('/reviews/delete/2');
        $this->assertResponseSuccess();
        $query = $reviews->find()->where(['id' => 2]);
        $this->assertEquals(0, $query->count());

        // Assistant
        $this->session(['Auth.User' => ['id' => 2, 'role' => 'assistant']]);
        $this->delete('/reviews/delete/3');
        $this->assertResponseSuccess();
        $query = $reviews->find()->where(['id' => 3]);
        $this->assertEquals(0, $query->count());
    }
}
