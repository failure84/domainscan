<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Domain'), ['action' => 'add']) ?></li>
	<li><?= $this->Html->link(__('List Vendors'), ['controller' => 'Vendors', 'action' => 'index']) ?></li>
    </ul>
</nav>
<div class="domains form large-9 medium-8 columns content">
    <?= $this->Form->create(null, [ 'type' => 'get' ]) ?>
    <fieldset>
        <legend><?= __('Search Domain') ?></legend>
        <?php
            echo $this->Form->input('search', array('label' => 'Search Domain (Full-Text Search, SphinxSearch)', 'value' => $search));
	    echo $this->Form->input('vendors_id', array('default' => $vendors_id, 'empty' => 'ALL'));
        ?>
    </fieldset>
    <?= $this->Form->button(__('Search')) ?>
    <?= $this->Form->end() ?>
</div>
<?php if (isset($domains)) { ?>
<div class="domains index large-9 medium-8 columns content">
    <h3><?= __('Domains') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('vendor_id', 'Vendors Name') ?></th>
                <th><?= $this->Paginator->sort('new_mx') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($domains as $domain): ?>
            <tr>
                <td><?= h($domain->name) ?></td>
                <td><?= h($domain->vendor->name) ?></td>
                <td><?= h($domain->new_mx) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $domain->id]) ?>
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
<?php } ?>
