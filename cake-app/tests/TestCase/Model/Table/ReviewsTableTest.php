<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ReviewsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ReviewsTable Test Case
 */
class ReviewsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ReviewsTable
     */
    public $Reviews;

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
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Reviews') ? [] : ['className' => ReviewsTable::class];
        $this->Reviews = TableRegistry::getTableLocator()->get('Reviews', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Reviews);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->assertEquals('reviews', $this->Reviews->getTable());
        $this->assertEquals('id', $this->Reviews->getDisplayField());
        $this->assertEquals('id', $this->Reviews->getPrimaryKey());

        $this->assertTrue($this->Reviews->hasBehavior('Timestamp'));
        $this->assertTrue($this->Reviews->hasBehavior('Trash'));

        $this->assertInstanceOf(\Cake\ORM\Association\BelongsTo::class, $this->Reviews->Users);
        $this->assertInstanceOf(\Cake\ORM\Association\BelongsTo::class, $this->Reviews->Books);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $data = [
            'rating' => 5,
            'comment' => 'Great book!',
            'user_id' => 1,
            'book_id' => 1,
        ];

        $review = $this->Reviews->newEntity($data);
        $this->assertEmpty($review->getErrors());

        $data['rating'] = 'not an integer';
        $review = $this->Reviews->newEntity($data);
        $this->assertArrayHasKey('rating', $review->getErrors());

        $data['rating'] = null;
        $review = $this->Reviews->newEntity($data);
        $this->assertArrayHasKey('rating', $review->getErrors());

        $data['rating'] = 5;
        $data['comment'] = str_repeat('A', 256);
        $review = $this->Reviews->newEntity($data);
        $this->assertArrayHasKey('comment', $review->getErrors());
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $data = [
            'rating' => 5,
            'comment' => 'Great book!',
            'user_id' => 1,
            'book_id' => 1,
        ];

        $review = $this->Reviews->newEntity($data);
        $result = $this->Reviews->save($review);
        $this->assertNotFalse($result);

        $data['user_id'] = 999;
        $review = $this->Reviews->newEntity($data);
        $result = $this->Reviews->save($review);
        $this->assertFalse($result);
    }

    /**
     * Test findByRole method
     *
     * @return void
     */
    public function testFindByRole()
    {
        $adminUser = ['id' => 1, 'role' => 'admin'];
        $assistantUser = ['id' => 2, 'role' => 'assistant'];
        $publisherUser = ['id' => 3, 'role' => 'publisher'];
        $memberUser = ['id' => 6, 'role' => 'member'];

        // Admin and Assistant should see all reviews
        $query = $this->Reviews->findByRole($this->Reviews->find(), ['user' => $adminUser]);
        $this->assertEquals(3, $query->count());

        $query = $this->Reviews->findByRole($this->Reviews->find(), ['user' => $assistantUser]);
        $this->assertEquals(3, $query->count());

        // Publisher should see only their books' reviews
        $query = $this->Reviews->findByRole($this->Reviews->find(), ['user' => $publisherUser]);
        $this->assertEquals(2, $query->count());

        // Member user should see only their own reviews
        $query = $this->Reviews->findByRole($this->Reviews->find(), ['user' => $memberUser]);
        $this->assertEquals(1, $query->count());
    }

    /**
     * Test findAverageRating method
     *
     * @return void
     */
    public function testFindAverageRating()
    {
        $query = $this->Reviews->find('averageRating');
        $results = $query->toArray();

        $this->assertNotEmpty($results);
        foreach ($results as $result) {
            $this->assertArrayHasKey('book_id', $result);
            $this->assertArrayHasKey('average_rating', $result);
            $this->assertInternalType('numeric', $result->average_rating);
        }
    }
}
