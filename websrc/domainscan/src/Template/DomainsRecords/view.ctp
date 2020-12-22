<?php $this->extend('../Layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('Edit Domains Record'), ['action' => 'edit', $domainsRecord->id], ['class' => 'nav-link']) ?></li>
<li><?= $this->Form->postLink( __('Delete Domains Record'), ['action' => 'delete', $domainsRecord->id], ['confirm' => __('Are you sure you want to delete # {0}?', $domainsRecord->id), 'class' => 'nav-link'] ) ?></li>
<li><?= $this->Html->link(__('List Domains Records'), ['action' => 'index'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('New Domains Record'), ['action' => 'add'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('List Domains'), ['controller' => 'Domains', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Domain'), ['controller' => 'Domains', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Vendors'), ['controller' => 'Vendors', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Vendor'), ['controller' => 'Vendors', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="domainsRecords view large-9 medium-8 columns content">
    <h3><?= h($domainsRecord->name) ?></h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th scope="row"><?= __('Domain') ?></th>
                <td><?= $domainsRecord->has('domain') ? $this->Html->link($domainsRecord->domain->name, ['controller' => 'Domains', 'action' => 'view', $domainsRecord->domain->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Vendor') ?></th>
                <td><?= $domainsRecord->has('vendor') ? $this->Html->link($domainsRecord->vendor->name, ['controller' => 'Vendors', 'action' => 'view', $domainsRecord->vendor->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Name') ?></th>
                <td><?= h($domainsRecord->name) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Type') ?></th>
                <td><?= h($domainsRecord->type) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($domainsRecord->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Value') ?></th>
                <td><?= $this->Number->format($domainsRecord->value) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($domainsRecord->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($domainsRecord->modified) ?></td>
            </tr>
        </table>
    </div>
</div>
