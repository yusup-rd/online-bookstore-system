<?php
namespace App\View\Helper;

use Cake\View\Helper;

/**
 * Review helper
 *
 * @property \Cake\View\Helper\HtmlHelper $Html
 */
class ReviewHelper extends Helper
{
    /**
     * Helpers.
     *
     * @var array
     */
    public $helpers = ['Html'];

    /**
     * Generates a link to the reviewer's profile.
     *
     * @param \App\Model\Entity\User|null $user The user entity (reviewer)
     * @return string HTML link to the user's profile or an empty string if user is null
     */
    public function linkToReviewer($user)
    {
        if ($user) {
            return $this->Html->link(
                $user->name,
                ['controller' => 'Users', 'action' => 'view', $user->id]
            );
        }

        return '';
    }

    /**
     * Generates a link to the book's details.
     *
     * @param \App\Model\Entity\Book|null $book The book entity
     * @param string|null $label The link label
     * @return string HTML link to the book's details or an empty string if book is null
     */
    public function linkToBook($book, $label = null)
    {
        if ($book) {
            $linkLabel = $label ?: h($book->title);

            return $this->Html->link(
                $linkLabel,
                ['controller' => 'Books', 'action' => 'view', $book->id]
            );
        }

        return '';
    }
}
