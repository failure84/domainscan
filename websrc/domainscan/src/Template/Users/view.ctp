<?php $this->extend('../Layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id], ['class' => 'nav-link']) ?></li>
<li><?= $this->Form->postLink( __('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'nav-link'] ) ?></li>
<li><?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('List Vendors'), ['controller' => 'Vendors', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Vendor'), ['controller' => 'Vendors', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->id) ?></h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th scope="row"><?= __('Username') ?></th>
                <td><?= h($user->username) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Password') ?></th>
                <td><?= h($user->password) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Role') ?></th>
                <td><?= h($user->role) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Vendor') ?></th>
                <td><?= $user->has('vendor') ? $this->Html->link($user->vendor->name, ['controller' => 'Vendors', 'action' => 'view', $user->vendor->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($user->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($user->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($user->modified) ?></td>
            </tr>
        </table>
    </div>
</div>
