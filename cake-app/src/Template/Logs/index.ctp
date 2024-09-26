<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Log[]|\Cake\Collection\CollectionInterface $logs
 * @var array $users
 */
?>
<?= $this->element('sidebar') ?>
<div class="logs index large-9 medium-8 columns content">
    <h3><?= __('Filters') ?></h3>
    <?php
        echo $this->Form->create(null, ['type' => 'get']);
        echo $this->Form->control('user_id', [
            'type' => 'select',
            'options' => $users,
            'empty' => 'All users',
            'label' => 'User',
            'value' => $this->request->getQuery('user_id'),
        ]);
        echo $this->Form->control('ip_address', [
            'label' => 'IP',
            'placeholder' => 'IP Address',
            'value' => $this->request->getQuery('ip_address'),
        ]);
        echo $this->Form->control('url', [
            'label' => 'URL',
            'placeholder' => 'URL Address',
            'value' => $this->request->getQuery('url'),
        ]);
        echo $this->Form->control('time_start', [
            'type' => 'datetime-local',
            'label' => 'From',
            'value' => $this->request->getQuery('time_start'),
        ]);
        echo $this->Form->control('time_end', [
            'type' => 'datetime-local',
            'label' => 'To',
            'value' => $this->request->getQuery('time_end'),
        ]); ?>
        <div class="columns small-12">
            <div class="button-group">
                <?= $this->Form->button(
                    '<i class="fas fa-search"></i> ' . __('Find'),
                    ['class' => 'button primary right', 'escapeTitle' => false]
                ) ?>
                <?= $this->Form->button(
                    '<i class="fas fa-undo-alt"></i> ' . __('Reset'),
                    [
                        'type' => 'button',
                        'onclick' => 'resetFilters()',
                        'class' => 'button secondary',
                        'escapeTitle' => false
                    ]
                ) ?>
            </div>
        </div>
        <?= $this->Form->end() ?>
    <h3><?= __('Logs') ?></h3>
    <table>
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('user_id', ['label' => 'User']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('url', ['label' => 'URL']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('ip_address', ['label' => 'IP']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('timestamp') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
            <tr>
                <td><?= $log->hasValue('user') ? $this->Html->link(
                        $log->user->name,
                        [
                            'controller' => 'Users',
                            'action' => 'view',
                            $log->user->id,
                        ]
                    ) : 'Public' ?>
                </td>
                <td><?= h($log->url) ?></td>
                <td><?= h($log->ip_address) ?></td>
                <td><?= h($log->timestamp) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('paginator') ?>
</div>

<script>
    function resetFilters() {
        document.querySelectorAll('form input, form select').forEach((input) => {
            input.value = '';
        });
        window.location.href = window.location.pathname;
    }
</script>
