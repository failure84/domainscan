<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Vendors Mx'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Vendors'), ['controller' => 'Vendors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Vendor'), ['controller' => 'Vendors', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="vendorsMxs index large-9 medium-8 columns content">
    <h3><?= __('Vendors Mxs') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('vendor_id') ?></th>
                <th><?= $this->Paginator->sort('value') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vendorsMxs as $vendorsMx): ?>
            <tr>
                <td><?= $this->Number->format($vendorsMx->id) ?></td>
                <td><?= $vendorsMx->has('vendor') ? $this->Html->link($vendorsMx->vendor->name, ['controller' => 'Vendors', 'action' => 'view', $vendorsMx->vendor->id]) : '' ?></td>
                <td><?= h($vendorsMx->value) ?></td>
                <td><?= h($vendorsMx->created) ?></td>
                <td><?= h($vendorsMx->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $vendorsMx->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $vendorsMx->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $vendorsMx->id], ['confirm' => __('Are you sure you want to delete # {0}?', $vendorsMx->id)]) ?>
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
