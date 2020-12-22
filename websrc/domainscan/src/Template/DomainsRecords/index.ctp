<?php $this->extend('../Layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('New Domains Record'), ['action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Domains'), ['controller' => 'Domains', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Domain'), ['controller' => 'Domains', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Vendors'), ['controller' => 'Vendors', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Vendor'), ['controller' => 'Vendors', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('domain_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('vendor_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('name') ?></th>
        <th scope="col"><?= $this->Paginator->sort('value') ?></th>
        <th scope="col"><?= $this->Paginator->sort('type') ?></th>
        <th scope="col"><?= $this->Paginator->sort('created') ?></th>
        <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($domainsRecords as $domainsRecord): ?>
        <tr>
            <td><?= $this->Number->format($domainsRecord->id) ?></td>
            <td><?= $domainsRecord->has('domain') ? $this->Html->link($domainsRecord->domain->name, ['controller' => 'Domains', 'action' => 'view', $domainsRecord->domain->id]) : '' ?></td>
            <td><?= $domainsRecord->has('vendor') ? $this->Html->link($domainsRecord->vendor->name, ['controller' => 'Vendors', 'action' => 'view', $domainsRecord->vendor->id]) : '' ?></td>
            <td><?= h($domainsRecord->name) ?></td>
            <td><?= $this->Number->format($domainsRecord->value) ?></td>
            <td><?= h($domainsRecord->type) ?></td>
            <td><?= h($domainsRecord->created) ?></td>
            <td><?= h($domainsRecord->modified) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $domainsRecord->id], ['title' => __('View'), 'class' => 'btn btn-secondary']) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $domainsRecord->id], ['title' => __('Edit'), 'class' => 'btn btn-secondary']) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $domainsRecord->id], ['confirm' => __('Are you sure you want to delete # {0}?', $domainsRecord->id), 'title' => __('Delete'), 'class' => 'btn btn-danger']) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="paginator">
    <ul class="pagination">
        <?= $this->Paginator->first('<< ' . __('First')) ?>
        <?= $this->Paginator->prev('< ' . __('Previous')) ?>
        <?= $this->Paginator->numbers(['before' => '', 'after' => '']) ?>
        <?= $this->Paginator->next(__('Next') . ' >') ?>
        <?= $this->Paginator->last(__('Last') . ' >>') ?>
    </ul>
    <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
</div>
