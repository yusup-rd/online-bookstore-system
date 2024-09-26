<?php
namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Logs Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Log get($primaryKey, $options = [])
 * @method \App\Model\Entity\Log newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Log[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Log|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Log saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Log patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Log[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Log findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Search\Model\Behavior\SearchBehavior
 */
class LogsTable extends Table
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

        $this->setTable('logs');
        $this->addBehavior('Timestamp');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'LEFT',
        ]);

        // Search plugin config
        $this->addBehavior('Search.Search');
        $this->searchManager()
            ->add('user_id', 'Search.Callback', [
                'callback' => function ($query, $args) {
                    if (isset($args['user_id'])) {
                        if ($args['user_id'] === 'public') {
                            $query->where(['Logs.user_id IS' => null]);
                        } elseif (!empty($args['user_id'])) {
                            $query->where(['Logs.user_id' => $args['user_id']]);
                        }
                    }

                    return $query;
                },
            ])
            ->value('ip_address', [
                'field' => 'Logs.ip_address',
            ])
            ->like('url', [
                'before' => true,
                'after' => true,
                'field' => 'Logs.url',
            ])
            ->add('time_start', 'Search.Callback', [
                'callback' => function ($query, $args) {
                    if (!empty($args['time_start'])) {
                        $query->where([
                            'Logs.timestamp >=' => date('Y-m-d H:i:s', strtotime($args['time_start'])),
                        ]);
                    }

                    return $query;
                },
            ])
            ->add('time_end', 'Search.Callback', [
                'callback' => function ($query, $args) {
                    if (!empty($args['time_end'])) {
                        $query->where([
                            'Logs.timestamp <=' => date('Y-m-d H:i:s', strtotime($args['time_end'])),
                        ]);
                    }

                    return $query;
                },
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
            ->scalar('url')
            ->maxLength('url', 255)
            ->requirePresence('url', 'create')
            ->notEmptyString('url');

        $validator
            ->scalar('ip_address')
            ->maxLength('ip_address', 50)
            ->requirePresence('ip_address', 'create')
            ->notEmptyString('ip_address');

        $validator
            ->dateTime('timestamp')
            ->notEmptyDateTime('timestamp');

        return $validator;
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
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
