<?php $this->extend('../Layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('Edit Vendors Mx'), ['action' => 'edit', $vendorsMx->id], ['class' => 'nav-link']) ?></li>
<li><?= $this->Form->postLink( __('Delete Vendors Mx'), ['action' => 'delete', $vendorsMx->id], ['confirm' => __('Are you sure you want to delete # {0}?', $vendorsMx->id), 'class' => 'nav-link'] ) ?></li>
<li><?= $this->Html->link(__('List Vendors Mxs'), ['action' => 'index'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('New Vendors Mx'), ['action' => 'add'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('List Vendors'), ['controller' => 'Vendors', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Vendor'), ['controller' => 'Vendors', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="vendorsMxs view large-9 medium-8 columns content">
    <h3><?= h($vendorsMx->id) ?></h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th scope="row"><?= __('Vendor') ?></th>
                <td><?= $vendorsMx->has('vendor') ? $this->Html->link($vendorsMx->vendor->name, ['controller' => 'Vendors', 'action' => 'view', $vendorsMx->vendor->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Value') ?></th>
                <td><?= h($vendorsMx->value) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($vendorsMx->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($vendorsMx->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($vendorsMx->modified) ?></td>
            </tr>
        </table>
    </div>
</div>
