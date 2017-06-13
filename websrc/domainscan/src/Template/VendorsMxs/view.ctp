<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Vendors Mx'), ['action' => 'edit', $vendorsMx->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Vendors Mx'), ['action' => 'delete', $vendorsMx->id], ['confirm' => __('Are you sure you want to delete # {0}?', $vendorsMx->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Vendors Mxs'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Vendors Mx'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Vendors'), ['controller' => 'Vendors', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Vendor'), ['controller' => 'Vendors', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="vendorsMxs view large-9 medium-8 columns content">
    <h3><?= h($vendorsMx->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Vendor') ?></th>
            <td><?= $vendorsMx->has('vendor') ? $this->Html->link($vendorsMx->vendor->name, ['controller' => 'Vendors', 'action' => 'view', $vendorsMx->vendor->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Value') ?></th>
            <td><?= h($vendorsMx->value) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($vendorsMx->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($vendorsMx->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($vendorsMx->modified) ?></td>
        </tr>
    </table>
</div>
