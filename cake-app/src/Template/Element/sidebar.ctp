<?php
use App\Model\Entity\User;
?>

<?php if (isset($authUser['role'])): ?>
    <nav class="large-3 medium-4 columns" id="actions-sidebar">
        <ul class="side-nav">
            <li class="heading"><?= __('Menu') ?></li>
            <li>
                <?= $this->Html->link(
                    '<i class="fas fa-home"></i> ' . __('Home'),
                    ['controller' => 'Books', 'action' => 'search'],
                    ['escape' => false]
                ) ?>
            </li>
            <li>
                <?= $this->Html->link(
                    '<i class="fas fa-users"></i> ' . __('Users'),
                    ['controller' => 'Users', 'action' => 'index'],
                    ['escape' => false]
                ) ?>
            </li>

            <?php if (!User::isMember($authUser['role'])): ?>
            <li>
                <?= $this->Html->link(
                    '<i class="fas fa-book"></i> ' . __('Books'),
                    ['controller' => 'Books', 'action' => 'index'],
                    ['escape' => false]
                ) ?>
            </li>
            <?php endif; ?>

            <?php if (User::isAdmin($authUser['role']) || User::isAssistant($authUser['role'])): ?>
                <li>
                    <?= $this->Html->link(
                        '<i class="fas fa-list"></i> ' . __('Categories'),
                        ['controller' => 'Categories', 'action' => 'index'],
                        ['escape' => false]
                    ) ?>
                </li>
            <?php endif; ?>

            <?php if (User::isAdmin($authUser['role'])): ?>
                <li>
                    <?= $this->Html->link(
                        '<i class="fas fa-file-alt"></i> ' . __('Logs'),
                        ['controller' => 'Logs', 'action' => 'index'],
                        ['escape' => false]
                    ) ?>
                </li>
            <?php endif; ?>

            <li>
                <?php
                $title = User::isMember($authUser['role']) ? __('My Reviews') : __('Reviews');
                echo $this->Html->link(
                    '<i class="fas fa-star"></i> ' . $title,
                    ['controller' => 'Reviews', 'action' => 'index'],
                    ['escape' => false]
                );
                ?>
            </li>
        </ul>
    </nav>
<?php endif; ?>
