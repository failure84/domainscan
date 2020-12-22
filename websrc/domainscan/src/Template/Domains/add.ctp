<?php $this->extend('../Layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('List Domains'), ['action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Vendors'), ['controller' => 'Vendors', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Vendor'), ['controller' => 'Vendors', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Domains Records'), ['controller' => 'DomainsRecords', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Domains Record'), ['controller' => 'DomainsRecords', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="domains form content">
    <?= $this->Form->create($domain) ?>
    <fieldset>
        <legend><?= __('Add Domain') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('errors');
            echo $this->Form->control('new_mx', ['empty' => true]);
            echo $this->Form->control('vendor_id', ['options' => $vendors]);
            echo $this->Form->control('note');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
