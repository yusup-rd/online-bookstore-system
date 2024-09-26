<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Book[]|\Cake\Collection\CollectionInterface $books
 * @var array $sessionUser
 * @var array $publishers
 * @var array $categories
 */
?>

<style>
    #search-filters-toggle {
        cursor: pointer;
        display: flex;
        align-items: center;
    }

    #chevron-icon {
        margin-left: 0.5rem;
        transition: transform 0.3s ease;
    }
</style>

<?= $this->element('sidebar') ?>
<div class="<?= $this->Book->getSearchClass($sessionUser) ?>">
    <div class="row">
        <h3 style="font-weight: 500;"><?= __('Welcome to Online Bookstore System') ?></h3>
        <div style="display: flex; justify-content: space-between; margin-top: 30px; flex-wrap: wrap;">
            <div style="flex: 1; margin-right: 1rem;">
                <?php echo $this->cell('Stats::display')->render(); ?>
            </div>
            <div style="flex: 1;">
                <?php echo $this->cell('Trends::display')->render(); ?>
            </div>
        </div>
        <div class="columns small-6" style="margin-top: 30px;">
            <h3 id="search-filters-toggle" style="font-weight: 500;"><?= __('Search Filters') ?>
                <span id="chevron-icon" class="fas fa-chevron-down" style="margin-left: 15px;"></span>
            </h3>
        </div>
    </div>
    <div class="row" id="search-filters" style="display: none;">
        <?= $this->Form->create(null, ['type' => 'get', 'url' => ['action' => 'search']]) ?>

        <div style="display: flex; justify-content: space-between;">
            <div style="flex: 2; padding-right: 1rem;">
                <p style="margin-bottom: 0.5rem; font-weight: bold;">Details</p>
                <?= $this->Form->control('title', [
                    'label' => false,
                    'placeholder' => __('Title'),
                    'value' => $this->getRequest()->getQuery('title'),
                ]) ?>
                <?= $this->Form->control('author', [
                    'label' => false,
                    'placeholder' => __('Author'),
                    'value' => $this->getRequest()->getQuery('author'),
                ]) ?>
                <?= $this->Form->control('user_id', [
                    'type' => 'select',
                    'options' => $publishers,
                    'empty' => __('All Publishers'),
                    'label' => false,
                    'value' => $this->getRequest()->getQuery('user_id'),
                ]) ?>
                <?= $this->Form->control('isbn', [
                    'label' => false,
                    'placeholder' => __('ISBN'),
                    'value' => $this->getRequest()->getQuery('isbn'),
                ]) ?>
            </div>
            <div style="display: flex; flex: 1; flex-direction: column;">
                <p style="margin-bottom: 0.5rem; font-weight: bold;">Categories</p>
                <div class="checkbox-group" style="overflow-y: auto; max-height: 195px; border: 1px solid #ccc; padding: 0.5rem;">
                    <label style="font-weight: bold;">
                        <input type="checkbox" id="select-all-categories">
                        <?= __('All Categories') ?>
                    </label>
                    <?= $this->Form->control('categories', [
                        'type' => 'select',
                        'multiple' => 'checkbox',
                        'options' => $categories,
                        'label' => false,
                        'value' => $this->getRequest()->getQuery('categories'),
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="filter-buttons">
            <?= $this->Form->button(
                '<i class="fas fa-search"></i> ' . __('Find'),
                [
                    'class' => 'button primary right',
                    'escapeTitle' => false,
                ]
            ) ?>
            <?= $this->Form->button(
                '<i class="fas fa-redo"></i> ' . __('Reset'),
                [
                    'type' => 'button',
                    'onclick' => 'resetFilters()',
                    'class' => 'button secondary',
                    'escapeTitle' => false,
                ]
            ) ?>
        </div>

        <?= $this->Form->end() ?>
    </div>
    <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 1rem; margin-top: 30px;">
        <?php if (count($books) > 0): ?>
            <?php foreach ($books as $book): ?>
                <?php $coverImage = $this->Book->getCoverImage($book); ?>
                <div style="width: 300px; margin-bottom: 1rem; text-align: center;">
                    <div style="margin-bottom: 1rem;">
                        <?= $this->Html->link(
                            $this->Html->image($coverImage['url'],
                                [
                                    'alt' => $coverImage['alt'],
                                    'style' => 'width:160px; height:250px; object-fit:cover; border-radius: 5px;',
                                ]
                            ),
                            ['action' => 'view', $book->id],
                            ['escape' => false]
                        ) ?>
                    </div>
                    <h4 style="margin: 0; font-size: 1.2em;"><?= h($book->title) ?></h4>
                    <p style="color: gray; font-size: 0.9em; font-style: italic;">
                        <?= $this->Book->getCategoryList($book) ?>
                    </p>
                    <p><strong><?= __('Author:') ?></strong> <?= h($book->author) ?></p>
                    <p><strong><?= __('Publisher:') ?></strong> <?= h($book->user->name) ?></p>
                    <div>
                        <?= $this->Html->link(
                            '<i class="fas fa-eye"></i> ' . __('View'),
                            ['action' => 'view', $book->id],
                            [
                                'class' => 'button',
                                'style' => 'display: block; width: 100%; margin-bottom: 2px;',
                                'escapeTitle' => false,
                            ]
                        ) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p><?= __('No books according to search') ?></p>
        <?php endif; ?>
    </div>
    <div class="row">
        <?= $this->element('paginator') ?>
    </div>
</div>

<script>
    // Function for displaying/removing search filter section
    document.getElementById('search-filters-toggle').addEventListener('click', function() {
        const filters = document.getElementById('search-filters');
        const chevronIcon = document.getElementById('chevron-icon');

        if (filters.style.display === 'none') {
            filters.style.display = 'block';
            chevronIcon.style.transform = 'rotate(-180deg)';
        } else {
            filters.style.display = 'none';
            chevronIcon.style.transform = 'rotate(0deg)';
        }
    });

    // Function for checking/unchecking all categories. Saves its value after search done.
    const selectAllCategoriesCheckbox = document.getElementById('select-all-categories');
    const categoryCheckboxes = document.querySelectorAll('input[name="categories[]"]');

    function initializeSelectAllCheckbox() {
        let allChecked = true;
        categoryCheckboxes.forEach(function(checkbox) {
            if (!checkbox.checked) {
                allChecked = false;
            }
        });
        selectAllCategoriesCheckbox.checked = allChecked;
    }

    selectAllCategoriesCheckbox.addEventListener('change', function() {
        categoryCheckboxes.forEach(function(checkbox) {
            checkbox.checked = selectAllCategoriesCheckbox.checked;
        });
    });

    categoryCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            initializeSelectAllCheckbox();
        });
    });

    initializeSelectAllCheckbox();

    // Function for resetting all the form fields to default empty values
    function resetFilters() {
        document.querySelectorAll('form input, form select').forEach((input) => {
            input.value = '';
        });
        window.location.href = window.location.pathname;
    }
</script>
