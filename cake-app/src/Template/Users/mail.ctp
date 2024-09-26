<?php
/**
 * @var \App\Model\Entity\User $user
 * @var \App\Model\Entity\User $emailForm
 */
?>

<?= $this->element('sidebar') ?>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($emailForm, ['novalidate' => true]) ?>
    <fieldset>
        <legend><?= __('Email Details') ?></legend>
        <p><?= __('Email recipient: {0} ({1})', h($user->name), h($user->email)) ?></p>
        <?= $this->Form->control('subject', ['label' => 'Subject']) ?>
        <?= $this->Form->control('message', ['label' => 'Message', 'type' => 'textarea', 'rows' => '5']) ?>
    </fieldset>
    <?= $this->element('footer_buttons') ?>
    <?= $this->Form->end() ?>
</div>
