<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Stat $stat
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Stat'), ['action' => 'edit', $stat->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Stat'), ['action' => 'delete', $stat->id], ['confirm' => __('Are you sure you want to delete # {0}?', $stat->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Stats'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Stat'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Vendors'), ['controller' => 'Vendors', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Vendor'), ['controller' => 'Vendors', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="stats view large-9 medium-8 columns content">
    <h3><?= h($stat->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Vendor') ?></th>
            <td><?= $stat->has('vendor') ? $this->Html->link($stat->vendor->name, ['controller' => 'Vendors', 'action' => 'view', $stat->vendor->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($stat->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total Domains') ?></th>
            <td><?= $this->Number->format($stat->total_domains) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date') ?></th>
            <td><?= h($stat->date) ?></td>
        </tr>
    </table>
</div>
