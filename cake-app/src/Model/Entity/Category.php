<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Category Entity
 *
 * @property int $id
 * @property string $name
 * @property bool $status
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Book[] $books
 */
class Category extends Entity
{
    const CATEGORY_STATUSES = [
        self::STATUS_ACTIVE => 'Enabled',
        self::STATUS_DISABLED => 'Disabled',
    ];

    const STATUS_ACTIVE = 1;
    const STATUS_DISABLED = 0;
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
        'name' => true,
        'status' => true,
        'deleted' => true,
        'created' => true,
        'modified' => true,
        'books' => true,
    ];
}
