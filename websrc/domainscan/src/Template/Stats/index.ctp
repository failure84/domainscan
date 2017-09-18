<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Stat[]|\Cake\Collection\CollectionInterface $stats
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Stat'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Vendors'), ['controller' => 'Vendors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Vendor'), ['controller' => 'Vendors', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="stats index large-9 medium-8 columns content">
    <h3><?= __('Stats') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('vendor_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total_domains') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stats as $stat): ?>
            <tr>
                <td><?= $this->Number->format($stat->id) ?></td>
                <td><?= h($stat->date) ?></td>
                <td><?= $stat->has('vendor') ? $this->Html->link($stat->vendor->name, ['controller' => 'Vendors', 'action' => 'view', $stat->vendor->id]) : '' ?></td>
                <td><?= $this->Number->format($stat->total_domains) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $stat->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $stat->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $stat->id], ['confirm' => __('Are you sure you want to delete # {0}?', $stat->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
