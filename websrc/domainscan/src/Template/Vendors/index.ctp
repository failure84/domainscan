<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Vendor'), ['action' => 'add']) ?></li>
	<li><?= $this->Html->link(__('List Domains'), ['controller' => 'Domains', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Vendors Mxs'), ['controller' => 'VendorsMxs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Vendors Mx'), ['controller' => 'VendorsMxs', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="vendors index large-9 medium-8 columns content">
    <h3><?= __('Vendors') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('total_domains') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vendors as $vendor): ?>
            <tr>
                <td><?= $this->Number->format($vendor->id) ?></td>
                <td><?= h($vendor->name) ?></td>
                <td><?= $this->Number->format($vendor->total_domains) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $vendor->id]) ?>
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
