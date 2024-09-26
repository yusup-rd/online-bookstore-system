<?php
namespace App\Model\Table;

use App\Model\Entity\Book;
use App\Model\Entity\User;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Books Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\CategoriesTable&\Cake\ORM\Association\BelongsToMany $Categories
 * @property \App\Model\Table\SummariesTable&\Cake\ORM\Association\HasMany $Summaries
 * @property \App\Model\Table\ReviewsTable&\Cake\ORM\Association\HasMany $Reviews
 *
 * @method \App\Model\Entity\Book get($primaryKey, $options = [])
 * @method \App\Model\Entity\Book newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Book[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Book|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Book saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Book patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Book[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Book findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Muffin\Trash\Model\Behavior\TrashBehavior
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Search\Model\Behavior\SearchBehavior
 */
class BooksTable extends Table
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

        $this->setTable('books');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Trash.Trash');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsToMany('Categories', [
            'foreignKey' => 'book_id',
            'targetForeignKey' => 'category_id',
            'joinTable' => 'books_categories',
        ]);
        $this->hasMany('Summaries', [
            'foreignKey' => 'search_id',
            'dependent' => true,
        ]);
        $this->hasMany('Reviews', [
            'foreignKey' => 'book_id',
        ]);

        // Search plugin config
        $this->addBehavior('Search.Search');
        $this->searchManager()
            ->like('title', [
                'before' => true,
                'after' => true,
            ])
            ->like('author', [
                'before' => true,
                'after' => true,
            ])
            ->add('user_id', 'Search.Callback', [
                'callback' => function ($query, $args) {
                    return $query->where(['Books.user_id IS' => $args['user_id']]);
                },
            ])
            ->value('isbn')
            ->add('categories', 'Search.Callback', [
                'callback' => function ($query, $args) {
                    if (!empty($args['categories']) && is_array($args['categories'])) {
                        return $query->matching('Categories', function ($q) use ($args) {
                            return $q->where(['Categories.id IN' => $args['categories']]);
                        });
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
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('isbn')
            ->maxLength('isbn', 50)
            ->requirePresence('isbn', 'create')
            ->notEmptyString('isbn');

        $validator
            ->scalar('author')
            ->maxLength('author', 255)
            ->requirePresence('author', 'create')
            ->notEmptyString('author');

        $validator
            ->scalar('synopsis')
            ->allowEmptyString('synopsis');

        $validator
            ->scalar('coverpage')
            ->maxLength('coverpage', 255)
            ->allowEmptyString('coverpage')
            ->add('coverpage', 'file', [
                'rule' => function ($value) {
                    // Validate file only if it is present
                    if (!empty($value['name'])) {
                        return in_array(
                            strtolower(pathinfo($value['name'], PATHINFO_EXTENSION)),
                            ['jpg', 'jpeg', 'png']
                        );
                    }
                    // Allow empty value
                    return true;
                },
                'message' => 'Invalid image format. Please upload a JPG, JPEG or PNG image.',
            ]);

        $validator
            ->scalar('url')
            ->maxLength('url', 255)
            ->allowEmptyString('url');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        $validator
            ->dateTime('deleted')
            ->allowEmptyDateTime('deleted');

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

    /**
     * findByUserRole custom finder method to paginate books based on the user's role.
     *
     * @param \Cake\ORM\Query $query The query object.
     * @param array $options Options containing the user data.
     * @return \Cake\ORM\Query The modified query object.
     */
    public function findByUserRole(Query $query, array $options)
    {
        $user = $options['user'];

        if (User::isPublisher($user['role'])) {
            $query->where(['Books.user_id' => $user['id']]);
        }

        return $query->contain(['Users']);
    }

    /**
     * deleteCoverPage method to delete the cover page file
     *
     * @param string $coverPage Coverpage file name
     * @return void
     */
    public function deleteCoverPage($coverPage)
    {
        $dir = new Folder(Book::COVER_PAGE_DIR, true, 0777);
        if (!empty($coverPage) && $coverPage !== 'cover_missing.jpg') {
            $file = new File($dir->path . DS . $coverPage);
            if ($file->exists()) {
                $file->delete();
            }
        }
    }

    /**
     * handleCoverPageUpload method to handle cover page upload and removal logic
     *
     * @param \App\Model\Entity\Book $book Book entity
     * @param array $data Request data
     * @param string|null $oldCoverPage Current coverpage (if exists)
     * @return \App\Model\Entity\Book Book entity
     */
    public function handleCoverPageUpload($book, $data, $oldCoverPage = null)
    {
        $dir = new Folder(Book::COVER_PAGE_DIR, true, 0777);

        // Handle cover page removal
        if (!empty($data['remove_coverpage'])) {
            $this->deleteCoverPage($book->coverpage);
            $book->coverpage = 'cover_missing.jpg';
        }

        // Handle new cover page upload
        if (!empty($data['coverpage']['name'])) {
            $file = $data['coverpage'];
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $timestamp = time();
            $newFileName = pathinfo($file['name'], PATHINFO_FILENAME) . '_' . $timestamp . '.' . $extension;
            $book->coverpage = $newFileName;

            // Move the uploaded file to the cover page directory
            $uploadedFile = new File($file['tmp_name']);
            if ($uploadedFile->copy($dir->path . DS . $newFileName)) {
                // Remove the old cover page file if it's not the default and different from the new one
                if ($oldCoverPage && $oldCoverPage !== 'cover_missing.jpg' && $oldCoverPage !== $newFileName) {
                    $this->deleteCoverPage($oldCoverPage);
                }
            } else {
                throw new \RuntimeException(__('Image could not be saved. Please, try again.'));
            }
        } elseif (!empty($data['current_coverpage'])) {
            $book->coverpage = $data['current_coverpage'];
        } else {
            $book->coverpage = $book->coverpage ?: 'cover_missing.jpg';
        }

        return $book;
    }

    /**
     * getAverageRating method to calculate the average rating of a book
     *
     * @param int $bookId Book ID
     * @return float|null Average rating
     */
    public function getAverageRating($bookId)
    {
        $result = $this->Reviews->find('averageRating')
            ->where(['Reviews.book_id' => $bookId])
            ->first();

        return $result ? (float)$result->average_rating : null;
    }
}
