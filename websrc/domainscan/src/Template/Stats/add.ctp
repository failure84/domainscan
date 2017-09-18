<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Stats'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Vendors'), ['controller' => 'Vendors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Vendor'), ['controller' => 'Vendors', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="stats form large-9 medium-8 columns content">
    <?= $this->Form->create($stat) ?>
    <fieldset>
        <legend><?= __('Add Stat') ?></legend>
        <?php
            echo $this->Form->control('date');
            echo $this->Form->control('vendor_id', ['options' => $vendors]);
            echo $this->Form->control('total_domains');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
