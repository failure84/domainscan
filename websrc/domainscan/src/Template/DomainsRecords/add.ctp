<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Domains Records'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Domains'), ['controller' => 'Domains', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Domain'), ['controller' => 'Domains', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Vendors'), ['controller' => 'Vendors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Vendor'), ['controller' => 'Vendors', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="domainsRecords form large-9 medium-8 columns content">
    <?= $this->Form->create($domainsRecord) ?>
    <fieldset>
        <legend><?= __('Add Domains Record') ?></legend>
        <?php
            echo $this->Form->input('domain_id', ['options' => $domains]);
            echo $this->Form->input('vendor_id', ['options' => $vendors, 'empty' => true]);
            echo $this->Form->input('name');
            echo $this->Form->input('value');
            echo $this->Form->input('type');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
