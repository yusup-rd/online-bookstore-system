<?php
namespace App\View\Helper;

use App\Model\Entity\User;
use Cake\View\Helper;

/**
 * Book helper
 *
 * @property \Cake\View\Helper\HtmlHelper $Html
 * @property \Cake\View\Helper\FormHelper $Form
 */
class BookHelper extends Helper
{
    /**
     * Helpers
     *
     * @var string[]
     */
    public $helpers = ['Html', 'Form'];

    /**
     * getSearchClass method to define div class resolution depending on user login
     *
     * @param array $sessionUser Session user
     * @return string
     */
    public function getSearchClass($sessionUser)
    {
        return $sessionUser ? 'books index large-9 medium-8 columns content' : 'books index large-12 medium-12 columns content';
    }

    /**
     * getCoverImage method to get the cover image URL and alt text for a book
     *
     * @param \App\Model\Entity\Book $book The book entity
     * @return array An array with 'url' and 'alt' keys
     */
    public function getCoverImage($book)
    {
        $imageUrl = (!empty($book->coverpage) && file_exists($book->coverpage_path))
            ? '/img/coverpage/' . $book->coverpage
            : '/img/coverpage/cover_missing.jpg';
        $imageAlt = (!empty($book->coverpage) && file_exists($book->coverpage_path))
            ? h($book->title)
            : __('No Cover Page');

        return ['url' => $imageUrl, 'alt' => $imageAlt];
    }

    /**
     * getCategoryList method to generate a string of category names for a book
     *
     * @param \App\Model\Entity\Book $book The book entity
     * @return string The formatted category names
     */
    public function getCategoryList($book)
    {
        if (!empty($book->categories)) {
            return h(implode(', ', collection($book->categories)->extract('name')->toList()));
        }

        return __('No category assigned');
    }

    /**
     * Display cover page logic.
     *
     * @param \App\Model\Entity\Book $book Book entity
     * @return string
     */
    public function displayCoverPage($book)
    {
        $html = '';

        if (!empty($book->coverpage) && $book->coverpage !== 'cover_missing.jpg' && file_exists($book->coverpage_path)) {
            $html .= '<p>Current Cover Page:</p>';
            $html .= $this->Html->image('coverpage' . DS . $book->coverpage, ['alt' => 'Cover Page', 'width' => '100']);
            $html .= $this->Form->control('remove_coverpage', [
                'type' => 'checkbox',
                'label' => 'Remove cover page',
            ]);
        } else {
            $html .= '<p>No cover page currently uploaded.</p>';
        }

        return $html;
    }

    /**
     * renderPublisherSelect method renders the publisher select input if the user is not a publisher.
     *
     * @param array $user The current user data.
     * @param array $publisherOptions Options for the publisher select input.
     * @param \App\Model\Entity\Book|null $book The book entity.
     * @return string The HTML for the publisher select input.
     */
    public function renderPublisherSelect($user, $publisherOptions, $book = null)
    {
        if (isset($book->user)) {
            $bookUser = $book->user;

            if ($bookUser->status === (bool)User::STATUS_INACTIVE) {
                return $this->Form->control('user_id', [
                    'label' => 'Publisher',
                    'type' => 'select',
                    'options' => [$book->user_id => $bookUser->name],
                    'disabled' => true,
                ]);
            }
        }

        if (!User::isPublisher($user['role'])) {
            return $this->Form->control('user_id', [
                'label' => 'Publisher',
                'type' => 'select',
                'options' => $publisherOptions,
            ]);
        }

        return '';
    }

    /**
     * displayUserName method displays the user's name as a link if the user has a role of admin or assistant
     *
     * @param \App\Model\Entity\Book $book The book entity
     * @param array $sessionUser The session user data
     * @return string The HTML for the user's name
     */
    public function displayUserName($book, $sessionUser = null)
    {
        if ($book->hasValue('user')) {
            $userRole = isset($sessionUser['role']) ? $sessionUser['role'] : null;

            if (User::isAdmin($userRole) || User::isAssistant($userRole)) {
                return $this->Html->link(
                    h($book->user->name),
                    ['controller' => 'Users', 'action' => 'view', $book->user->id]
                );
            }

            return h($book->user->name);
        }

        return '';
    }
}
