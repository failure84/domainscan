<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Domains'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Domains Records'), ['controller' => 'DomainsRecords', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Domains Record'), ['controller' => 'DomainsRecords', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="domains form large-9 medium-8 columns content">
    <?= $this->Form->create($domain) ?>
    <fieldset>
        <legend><?= __('Add Domain') ?></legend>
        <?php
            echo $this->Form->input('name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
