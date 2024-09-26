<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Book Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $isbn
 * @property string $author
 * @property string|null $synopsis
 * @property string|null $coverpage
 * @property string|null $url
 * @property bool $status
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Category[] $categories
 * @property \App\Model\Entity\Summary[] $summaries
 * @property \App\Model\Entity\Review[] $reviews
 * @property string $display_status
 * @property string $coverpage_path
 */
class Book extends Entity
{
    const BOOK_STATUSES = [
        1 => 'Visible for public',
        0 => 'Disabled for public',
    ];

    const COVER_PAGE_DIR = WWW_ROOT . 'img' . DS . 'coverpage';

    const TREND_BOOKS_LIMIT = 5; // Limit the number of books to display on the homepage's TrendsCell

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
        'user_id' => true,
        'title' => true,
        'isbn' => true,
        'author' => true,
        'synopsis' => true,
        'coverpage' => true,
        'url' => true,
        'status' => true,
        'deleted' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'categories' => true,
        'summaries' => true,
        'reviews' => true,
    ];

    /**
     * Virtual accessor
     *
     * @var string[]
     */
    protected $_virtual = ['display_status', 'coverpage_path'];

    /**
     * Get the display status
     *
     * @return string
     */
    protected function _getDisplayStatus()
    {
        return $this->status ? __('Visible for public') : __('Disabled for public');
    }

    /**
     * Get the cover page path.
     *
     * @return string
     */
    protected function _getCoverpagePath()
    {
        return self::COVER_PAGE_DIR . DS . $this->coverpage;
    }
}
