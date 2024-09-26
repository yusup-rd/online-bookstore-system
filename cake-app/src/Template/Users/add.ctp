<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var array $sessionUser
 */
?>

<?= $this->element('sidebar') ?>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <?php
            echo $this->Form->control('login');
            echo $this->Form->control('password');
            echo $this->User->displayRoleInput($sessionUser);
            echo $this->Form->control('name');
            echo $this->Form->control('address');
            echo $this->Form->control('phone');
            echo $this->Form->control('fax');
            echo $this->Form->control('email');
            echo $this->Form->control('url');
            echo $this->User->displayStatusInput($sessionUser);
        ?>
    </fieldset>
    <?= $this->element('footer_buttons') ?>
    <?= $this->Form->end() ?>
</div>
