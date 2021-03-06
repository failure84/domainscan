<?php $this->extend('../Layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $vendorsMx->id], ['confirm' => __('Are you sure you want to delete # {0}?', $vendorsMx->id), 'class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Vendors Mxs'), ['action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Vendors'), ['controller' => 'Vendors', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Vendor'), ['controller' => 'Vendors', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="vendorsMxs form content">
    <?= $this->Form->create($vendorsMx) ?>
    <fieldset>
        <legend><?= __('Edit Vendors Mx') ?></legend>
        <?php
            echo $this->Form->control('vendor_id', ['options' => $vendors]);
            echo $this->Form->control('value');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
