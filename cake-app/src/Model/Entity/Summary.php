<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Summary Entity
 *
 * @property int $id
 * @property int $search_id
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\Book $book
 */
class Summary extends Entity
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
        'search_id' => true,
        'created' => true,
        'book' => true,
    ];
}
