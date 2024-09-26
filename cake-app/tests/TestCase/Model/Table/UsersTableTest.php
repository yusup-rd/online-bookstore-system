<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\User;
use App\Model\Table\UsersTable;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersTable Test Case
 */
class UsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersTable
     */
    public $Users;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        $config = TableRegistry::getTableLocator()->exists('Users') ? [] : ['className' => UsersTable::class];
        $this->Users = TableRegistry::getTableLocator()->get('Users', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Users);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->assertInstanceOf(UsersTable::class, $this->Users);
        $this->assertEquals('users', $this->Users->getTable());
        $this->assertTrue($this->Users->hasBehavior('Timestamp'));
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $validator = $this->Users->getValidator('default');

        $this->assertNotEmpty($validator->field('login'));
        $this->assertNotEmpty($validator->field('email'));
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        // New user entity with duplicate login and email
        $duplicateUser = $this->Users->newEntity([
            'login' => 'adminuser', // Duplicate login
            'email' => 'admin@example.com', // Duplicate email
            'password' => '@NewPassword123',
            'role' => 'admin',
            'name' => 'Duplicate User',
            'address' => 'Duplicate Address',
            'phone' => '0000000000',
            'fax' => '0000000000',
            'url' => 'https://example.com',
            'status' => 1,
            'deleted' => null,
        ]);

        $result = $this->Users->save($duplicateUser);
        $this->assertFalse($result, 'The user with duplicate login and email should not be saved.');

        // New user entity with unique login and email
        $uniqueUser = $this->Users->newEntity([
            'login' => 'uniqueuser', // Unique login
            'email' => 'unique@example.com', // Unique email
            'password' => '@NewPassword123',
            'role' => 'admin',
            'name' => 'Unique User',
            'address' => 'Unique Address',
            'phone' => '0000000000',
            'fax' => '0000000000',
            'url' => 'https://example.com',
            'status' => 1,
            'deleted' => null,
        ]);

        $result = $this->Users->save($uniqueUser);
        $this->assertInstanceOf(User::class, $result, 'The user with unique login and email should be saved.');
    }

    /**
     * Test findByRole method.
     *
     * @return void
     */
    public function testFindByRole()
    {
        $adminUser = [
            'id' => 1,
            'role' => 'admin',
        ];

        $assistantUser = [
            'id' => 2,
            'role' => 'assistant',
        ];

        $publisherUser = [
            'id' => 3,
            'role' => 'publisher',
        ];

        // Admin: should see all users
        $query = $this->Users->find('byRole', ['user' => $adminUser]);
        $result = $query->all()->toArray();
        $this->assertNotEmpty($result);
        $this->assertGreaterThanOrEqual(3, count($result));

        // Assistant: should see publishers and themselves
        $query = $this->Users->find('byRole', ['user' => $assistantUser]);
        $result = $query->all()->toArray();
        $this->assertNotEmpty($result);
        $this->assertGreaterThanOrEqual(2, count($result));

        // Publisher: should see only themselves
        $query = $this->Users->find('byRole', ['user' => $publisherUser]);
        $result = $query->all()->toArray();
        $this->assertNotEmpty($result);
        $this->assertCount(1, $result);
        $this->assertEquals($publisherUser['id'], $result[0]->id);
    }

    /**
     * Test findPublishers method.
     *
     * @return void
     * @throws \Exception
     */
    public function testFindPublishers()
    {
        $query = $this->Users->find('publishers');
        $result = $query->all()->toArray();
        $this->assertCount(2, $result, 'The result should include publishers who are not soft-deleted.');

        $query = $this->Users->find('publishers', ['active' => true]);
        $result = $query->all()->toArray();
        $this->assertCount(1, $result, 'There should be exactly one active publisher.');

        $query = $this->Users->find('publishers', ['active' => true]);
        $result = $query->matching('Books')->all()->toArray();
        $this->assertNotEmpty($result, 'Active publisher should have associated books.');
    }

    /**
     * Test findUserByEmail method.
     *
     * @return void
     */
    public function testFindUserByEmail()
    {
        $email = 'publisher1@example.com';
        $user = $this->Users->findUserByEmail($this->Users->find(), ['email' => $email]);
        $this->assertInstanceOf(Query::class, $user);
        $results = $user->all()->toArray();
        $this->assertNotEmpty($results, 'Expected user with email ' . $email . ' to be found.');
        $this->assertEquals($email, $results[0]->email, 'User email does not match the expected value.');
    }

    /**
     * Test getToken method.
     *
     * @return void
     */
    public function testGetToken()
    {
        $email = 'test@example.com';
        $token = 'generated-token';

        $user = $this->getMockBuilder(User::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->Users = $this->getMockBuilder(UsersTable::class)
            ->setMethods(['find', 'save', 'generateToken'])
            ->getMock();

        $query = $this->getMockBuilder(Query::class)
            ->disableOriginalConstructor()
            ->getMock();

        $query->expects($this->once())
            ->method('first')
            ->willReturn($user);

        $this->Users->expects($this->once())
            ->method('find')
            ->with('userByEmail', ['email' => $email])
            ->willReturn($query);

        $this->Users->expects($this->once())
            ->method('generateToken')
            ->willReturn($token);

        $this->Users->expects($this->once())
            ->method('save')
            ->with($user)
            ->willReturn(true);

        $result = $this->Users->getToken($email);
        $this->assertEquals(['token' => $token], $result);
    }

    public function testGenerateToken()
    {
        $token = $this->Users->generateToken();
        $this->assertNotEmpty($token);
        $this->assertInternalType('string', $token);
    }
}
