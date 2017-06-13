<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Domains Record'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Domains'), ['controller' => 'Domains', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Domain'), ['controller' => 'Domains', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Vendors'), ['controller' => 'Vendors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Vendor'), ['controller' => 'Vendors', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="domainsRecords index large-9 medium-8 columns content">
    <h3><?= __('Domains Records') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('domain_id') ?></th>
                <th><?= $this->Paginator->sort('vendor_id') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('value') ?></th>
                <th><?= $this->Paginator->sort('type') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($domainsRecords as $domainsRecord): ?>
            <tr>
                <td><?= $this->Number->format($domainsRecord->id) ?></td>
                <td><?= $domainsRecord->has('domain') ? $this->Html->link($domainsRecord->domain->name, ['controller' => 'Domains', 'action' => 'view', $domainsRecord->domain->id]) : '' ?></td>
                <td><?= $domainsRecord->has('vendor') ? $this->Html->link($domainsRecord->vendor->name, ['controller' => 'Vendors', 'action' => 'view', $domainsRecord->vendor->id]) : '' ?></td>
                <td><?= h($domainsRecord->name) ?></td>
                <td><?= h($domainsRecord->value) ?></td>
                <td><?= h($domainsRecord->type) ?></td>
                <td><?= h($domainsRecord->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $domainsRecord->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $domainsRecord->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $domainsRecord->id], ['confirm' => __('Are you sure you want to delete # {0}?', $domainsRecord->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
