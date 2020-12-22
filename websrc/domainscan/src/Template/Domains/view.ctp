<?php $this->extend('../Layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('Edit Domain'), ['action' => 'edit', $domain->id], ['class' => 'nav-link']) ?></li>
<li><?= $this->Form->postLink( __('Delete Domain'), ['action' => 'delete', $domain->id], ['confirm' => __('Are you sure you want to delete # {0}?', $domain->id), 'class' => 'nav-link'] ) ?></li>
<li><?= $this->Html->link(__('List Domains'), ['action' => 'index'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('New Domain'), ['action' => 'add'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('List Vendors'), ['controller' => 'Vendors', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Vendor'), ['controller' => 'Vendors', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Domains Records'), ['controller' => 'DomainsRecords', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Domains Record'), ['controller' => 'DomainsRecords', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="domains view large-9 medium-8 columns content">
    <h3><?= h($domain->name) ?></h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th scope="row"><?= __('Name') ?></th>
                <td><?= $this->Html->Link($domain->name, 'http://' . $domain->name . '/', ['target' => '_blank']) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Vendor') ?></th>
                <td><?= $domain->has('vendor') ? $this->Html->link($domain->vendor->name, ['controller' => 'Vendors', 'action' => 'view', $domain->vendor->id]) : '' ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Note') ?></th>
                <td><?= h($domain->note) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($domain->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Errors') ?></th>
                <td><?= $this->Number->format($domain->errors) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('New Mx') ?></th>
                <td><?= h($domain->new_mx) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($domain->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($domain->modified) ?></td>
            </tr>
        </table>
    </div>
    <div class="related">
        <h4><?= __('Related Domains Records') ?></h4>
        <?php if (!empty($domain->domains_records)): ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Domain Id') ?></th>
                    <th scope="col"><?= __('Vendor Id') ?></th>
                    <th scope="col"><?= __('Name') ?></th>
                    <th scope="col"><?= __('Value') ?></th>
                    <th scope="col"><?= __('Type') ?></th>
                    <th scope="col"><?= __('Created') ?></th>
                    <th scope="col"><?= __('Modified') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($domain->domains_records as $domainsRecords): ?>
                <tr>
                    <td><?= h($domainsRecords->id) ?></td>
                    <td><?= h($domainsRecords->domain_id) ?></td>
                    <td><?= h($domainsRecords->vendor_id) ?></td>
                    <td><?= h($domainsRecords->name) ?></td>
                    <td><?= h($domainsRecords->value) ?></td>
                    <td><?= h($domainsRecords->type) ?></td>
                    <td><?= h($domainsRecords->created) ?></td>
                    <td><?= h($domainsRecords->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['controller' => 'DomainsRecords', 'action' => 'view', $domainsRecords->id], ['class' => 'btn btn-secondary']) ?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'DomainsRecords', 'action' => 'edit', $domainsRecords->id], ['class' => 'btn btn-secondary']) ?>
                        <?= $this->Form->postLink( __('Delete'), ['controller' => 'DomainsRecords', 'action' => 'delete', $domainsRecords->id], ['confirm' => __('Are you sure you want to delete # {0}?', $domainsRecords->id), 'class' => 'btn btn-danger']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>
