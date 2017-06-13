<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Vendors'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Vendors Mxs'), ['controller' => 'VendorsMxs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Vendors Mx'), ['controller' => 'VendorsMxs', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="vendors form large-9 medium-8 columns content">
    <?= $this->Form->create($vendor) ?>
    <fieldset>
        <legend><?= __('Add Vendor') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('comment');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
