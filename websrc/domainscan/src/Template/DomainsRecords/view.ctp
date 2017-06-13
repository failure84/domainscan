<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Domains Record'), ['action' => 'edit', $domainsRecord->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Domains Record'), ['action' => 'delete', $domainsRecord->id], ['confirm' => __('Are you sure you want to delete # {0}?', $domainsRecord->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Domains Records'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Domains Record'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Domains'), ['controller' => 'Domains', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Domain'), ['controller' => 'Domains', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Vendors'), ['controller' => 'Vendors', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Vendor'), ['controller' => 'Vendors', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="domainsRecords view large-9 medium-8 columns content">
    <h3><?= h($domainsRecord->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Domain') ?></th>
            <td><?= $domainsRecord->has('domain') ? $this->Html->link($domainsRecord->domain->name, ['controller' => 'Domains', 'action' => 'view', $domainsRecord->domain->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Vendor') ?></th>
            <td><?= $domainsRecord->has('vendor') ? $this->Html->link($domainsRecord->vendor->name, ['controller' => 'Vendors', 'action' => 'view', $domainsRecord->vendor->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($domainsRecord->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Value') ?></th>
            <td><?= h($domainsRecord->value) ?></td>
        </tr>
        <tr>
            <th><?= __('Type') ?></th>
            <td><?= h($domainsRecord->type) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($domainsRecord->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($domainsRecord->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($domainsRecord->modified) ?></td>
        </tr>
    </table>
</div>
