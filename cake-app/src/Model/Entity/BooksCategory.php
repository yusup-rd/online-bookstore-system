<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BooksCategory Entity
 *
 * @property int $id
 * @property int $book_id
 * @property int $category_id
 *
 * @property \App\Model\Entity\Book $book
 * @property \App\Model\Entity\Category $category
 */
class BooksCategory extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'book_id' => true,
        'category_id' => true,
        'book' => true,
        'category' => true,
    ];
}
