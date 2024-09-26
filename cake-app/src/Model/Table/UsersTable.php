<?php
namespace App\Model\Table;

use App\Model\Entity\User;
use App\Model\Validation\PasswordValidationSet;
use Cake\I18n\FrozenTime;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Security;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\BooksTable&\Cake\ORM\Association\HasMany $Books
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Muffin\Trash\Model\Behavior\TrashBehavior
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Trash.Trash');

        $this->hasMany('Books', [
            'foreignKey' => 'user_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('login')
            ->maxLength('login', 255)
            ->requirePresence('login', 'create')
            ->notEmptyString('login');

        $validator
            ->scalar('password')
            ->requirePresence('password', 'create')
            ->add('password', (new PasswordValidationSet())->rules())
            ->sameAs('confirm_password', 'password', __('Passwords do not match'))
            ->notEmptyString('password');

        $validator
            ->scalar('role')
            ->maxLength('role', 20)
            ->requirePresence('role', 'create')
            ->notEmptyString('role');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('address')
            ->maxLength('address', 255)
            ->allowEmptyString('address');

        $validator
            ->scalar('phone')
            ->maxLength('phone', 20)
            ->allowEmptyString('phone');

        $validator
            ->scalar('fax')
            ->maxLength('fax', 20)
            ->allowEmptyString('fax');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->scalar('url')
            ->maxLength('url', 255)
            ->allowEmptyString('url');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        $validator
            ->scalar('token')
            ->maxLength('token', 255)
            ->allowEmptyString('token');

        $validator
            ->dateTime('token_expired_at')
            ->allowEmptyDateTime('token_expired_at');

        $validator
            ->dateTime('deleted')
            ->allowEmptyDateTime('deleted');

        return $validator;
    }

    /**
     * Validation rules for member registration.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationMemberRegistration(Validator $validator)
    {
        $validator
            ->scalar('login')
            ->maxLength('login', 255)
            ->requirePresence('login', 'create')
            ->notEmptyString('login');

        $validator
            ->scalar('password')
            ->requirePresence('password', 'create')
            ->add('password', (new PasswordValidationSet())->rules())
            ->sameAs('confirm_password', 'password', __('Passwords do not match'))
            ->notEmptyString('password');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        return $validator;
    }

    /**
     * Validation rules for updating the password.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationUpdatePassword(Validator $validator)
    {
        return $validator
            ->add('current_password', 'custom', [
                'rule' => function ($value, $context) {
                    return password_verify($value, $context['data']['user']['password']);
                },
                'message' => 'Current password is incorrect',
            ])
            ->notEmptyString('current_password', __('Current password is required'))
            ->notEmptyString('password', __('New password is required'))
            ->add('password', (new PasswordValidationSet())->rules())
            ->sameAs('confirm_password', 'password', __('Passwords do not match'));
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['login']));
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }

    /**
     * findForUser custom finder method for role based pagination
     *
     * @param \Cake\ORM\Query $query Query
     * @param array $options User role options
     * @return \Cake\ORM\Query|void
     */
    public function findByRole(Query $query, array $options)
    {
        $user = $options['user'];

        if (User::isAdmin($user['role'])) {
            return $query;
        }

        if (User::isAssistant($user['role'])) {
            return $query->where([
                'OR' => [
                    'Users.role' => User::ROLE_PUBLISHER,
                    'Users.id' => $user['id'],
                ],
            ]);
        }

        if (User::isPublisher($user['role']) || User::isMember($user['role'])) {
            return $query->where(['Users.id' => $user['id']]);
        }
    }

    /**
     * findPublishers custom finder method to query all or active publishers.
     *
     * @param \Cake\ORM\Query $query The query object.
     * @param array $options Options containing the user data.
     * @return \Cake\ORM\Query The modified query object.
     */
    public function findPublishers(Query $query, array $options)
    {
        $conditions = ['Users.role' => User::ROLE_PUBLISHER];

        if (isset($options['active'])) {
            $conditions['Users.status'] = User::STATUS_ACTIVE;
        }

        return $query->find('list', [
            'keyField' => 'id',
            'valueField' => 'name',
        ])
            ->matching('Books', function ($q) use ($options) {
                return !empty($options['active']) ? $q->select(['Books.user_id']) : $q;
            })
            ->where($conditions);
    }

    /**
     * findUserByEmail custom finder method to find user according to email.
     *
     * @param Query $query The query object.
     * @param array $options Options containing the user data.
     * @return Query
     */
    public function findUserByEmail(Query $query, array $options)
    {
        return $query->where(['email' => $options['email']]);
    }

    /**
     * getToken method to generate and save a password reset token (any user) or registration token (member role) for the user.
     *
     * @param string $email The email address of the user.
     * @return array|bool False on failure or an array with the token on success.
     */
    public function getToken($email)
    {
        /**
         * @var \App\Model\Entity\User|null $user
         */
        $user = $this->find('userByEmail', ['email' => $email])->first();

        if (!$user) {
            return false;
        }

        $token = $this->generateToken();
        $user->token = $token;
        $user->token_expired_at = FrozenTime::now()->addMinutes(User::TOKEN_EXPIRY_IN_MINUTES);

        if ($this->save($user)) {
            return ['token' => $token];
        }

        return false;
    }

    /**
     * generateToken method
     *
     * @return string
     */
    public function generateToken()
    {
        return Security::hash(Security::randomBytes(25), 'sha256', true);
    }
}
