<?php
namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Summaries Model
 *
 * @property \App\Model\Table\BooksTable&\Cake\ORM\Association\BelongsTo $Books
 *
 * @method \App\Model\Entity\Summary get($primaryKey, $options = [])
 * @method \App\Model\Entity\Summary newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Summary[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Summary|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Summary saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Summary patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Summary[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Summary findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SummariesTable extends Table
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

        $this->setTable('summaries');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Books', [
            'foreignKey' => 'search_id',
            'joinType' => 'INNER',
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

        return $validator;
    }

    /**
     * Build rules for validating application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['search_id'], 'Books'));

        return $rules;
    }

    /**
     * logSummary method to create a new entry in SummariesTable.
     *
     * @param int $bookId Book ID
     * @return bool
     */
    public function logSummary($bookId)
    {
        $summary = $this->newEntity();
        $summary->search_id = $bookId;

        if ($this->save($summary)) {
            return true;
        }

        return false;
    }

    /**
     * Get top search IDs by count.
     *
     * @param int $limit The number of top search IDs to retrieve.
     * @return array The list of top search IDs.
     */
    public function getTopSearchIds($limit)
    {
        return $this->find()
            ->select([
                'search_id',
                'count' => $this->find()->func()->count('search_id'),
            ])
            ->group('search_id')
            ->order(['count' => 'DESC'])
            ->limit($limit)
            ->all()
            ->extract('search_id')
            ->toList();
    }
}
