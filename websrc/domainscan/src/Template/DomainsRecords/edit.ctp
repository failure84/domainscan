<?php $this->extend('../Layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $domainsRecord->id], ['confirm' => __('Are you sure you want to delete # {0}?', $domainsRecord->id), 'class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Domains Records'), ['action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Domains'), ['controller' => 'Domains', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Domain'), ['controller' => 'Domains', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Vendors'), ['controller' => 'Vendors', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Vendor'), ['controller' => 'Vendors', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="domainsRecords form content">
    <?= $this->Form->create($domainsRecord) ?>
    <fieldset>
        <legend><?= __('Edit Domains Record') ?></legend>
        <?php
            echo $this->Form->control('domain_id', ['options' => $domains]);
            echo $this->Form->control('vendor_id', ['options' => $vendors, 'empty' => true]);
            echo $this->Form->control('name');
            echo $this->Form->control('value');
            echo $this->Form->control('type');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
