<?php $this->extend('../Layout/TwitterBootstrap/dashboard'); ?>

<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('Edit Vendor'), ['action' => 'edit', $vendor->id], ['class' => 'nav-link']) ?></li>
<li><?= $this->Form->postLink( __('Delete Vendor'), ['action' => 'delete', $vendor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $vendor->id), 'class' => 'nav-link'] ) ?></li>
<li><?= $this->Html->link(__('List Vendors'), ['action' => 'index'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('New Vendor'), ['action' => 'add'], ['class' => 'nav-link']) ?> </li>
<li><?= $this->Html->link(__('List Vendors Mxs'), ['controller' => 'VendorsMxs', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Vendors Mx'), ['controller' => 'VendorsMxs', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Domains'), ['controller' => 'Domains', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Domain'), ['controller' => 'Domains', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Stats'), ['controller' => 'Stats', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Stat'), ['controller' => 'Stats', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="vendors view large-9 medium-8 columns content">
    <h3><?= h($vendor->name) ?></h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th scope="row"><?= __('Name') ?></th>
                <td><?= h($vendor->name) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Id') ?></th>
                <td><?= $this->Number->format($vendor->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($vendor->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($vendor->modified) ?></td>
            </tr>
        </table>
    </div>
    <div class="row">
        <h4><?= __('Comment') ?></h4>
        <?= $this->Text->autoParagraph(h($vendor->comment)); ?>
    </div>
    <div class="row">
    <?= $this->Html->image($this->Url->build('img/domain_' . $vendor->id . '.png'), [ 'width' => '100%', 'height' => '100%' ]) ?>
    </div>
    <div class="related">
        <h4><?= __('Related Vendors Mxs') ?></h4>
        <?php if (!empty($vendor->vendors_mxs)): ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Vendor Id') ?></th>
                    <th scope="col"><?= __('Value') ?></th>
                    <th scope="col"><?= __('Created') ?></th>
                    <th scope="col"><?= __('Modified') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($vendor->vendors_mxs as $vendorsMxs): ?>
                <tr>
                    <td><?= h($vendorsMxs->id) ?></td>
                    <td><?= h($vendorsMxs->vendor_id) ?></td>
                    <td><?= h($vendorsMxs->value) ?></td>
                    <td><?= h($vendorsMxs->created) ?></td>
                    <td><?= h($vendorsMxs->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['controller' => 'VendorsMxs', 'action' => 'view', $vendorsMxs->id], ['class' => 'btn btn-secondary']) ?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'VendorsMxs', 'action' => 'edit', $vendorsMxs->id], ['class' => 'btn btn-secondary']) ?>
                        <?= $this->Form->postLink( __('Delete'), ['controller' => 'VendorsMxs', 'action' => 'delete', $vendorsMxs->id], ['confirm' => __('Are you sure you want to delete # {0}?', $vendorsMxs->id), 'class' => 'btn btn-danger']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Domains') ?></h4>
        <?php if (!empty($domains)): ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Name') ?></th>
                    <th scope="col"><?= __('Errors') ?></th>
                    <th scope="col"><?= __('New Mx') ?></th>
                    <th scope="col"><?= __('Vendor Id') ?></th>
                    <th scope="col"><?= __('Note') ?></th>
                    <th scope="col"><?= __('Created') ?></th>
                    <th scope="col"><?= __('Modified') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($domains as $domain): ?>
                <tr>
                    <td><?= h($domain->id) ?></td>
                    <td><?= h($domain->name) ?></td>
                    <td><?= h($domain->errors) ?></td>
                    <td><?= h($domain->new_mx) ?></td>
                    <td><?= h($domain->vendor_id) ?></td>
                    <td><?= h($domain->note) ?></td>
                    <td><?= h($domain->created) ?></td>
                    <td><?= h($domain->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['controller' => 'Domains', 'action' => 'view', $domain->id], ['class' => 'btn btn-secondary']) ?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'Domains', 'action' => 'edit', $domain->id], ['class' => 'btn btn-secondary']) ?>
                        <?= $this->Form->postLink( __('Delete'), ['controller' => 'Domains', 'action' => 'delete', $domain->id], ['confirm' => __('Are you sure you want to delete # {0}?', $domain->id), 'class' => 'btn btn-danger']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->first('<< ' . __('First')) ?>
                <?= $this->Paginator->prev('< ' . __('Previous')) ?>
                <?= $this->Paginator->numbers(['before' => '', 'after' => '']) ?>
                <?= $this->Paginator->next(__('Next') . ' >') ?>
                <?= $this->Paginator->last(__('Last') . ' >>') ?>
            </ul>
            <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
        </div>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Users') ?></h4>
        <?php if (!empty($vendor->users)): ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Username') ?></th>
                    <th scope="col"><?= __('Password') ?></th>
                    <th scope="col"><?= __('Role') ?></th>
                    <th scope="col"><?= __('Vendor Id') ?></th>
                    <th scope="col"><?= __('Created') ?></th>
                    <th scope="col"><?= __('Modified') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($vendor->users as $users): ?>
                <tr>
                    <td><?= h($users->id) ?></td>
                    <td><?= h($users->username) ?></td>
                    <td><?= h($users->password) ?></td>
                    <td><?= h($users->role) ?></td>
                    <td><?= h($users->vendor_id) ?></td>
                    <td><?= h($users->created) ?></td>
                    <td><?= h($users->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['controller' => 'Users', 'action' => 'view', $users->id], ['class' => 'btn btn-secondary']) ?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'Users', 'action' => 'edit', $users->id], ['class' => 'btn btn-secondary']) ?>
                        <?= $this->Form->postLink( __('Delete'), ['controller' => 'Users', 'action' => 'delete', $users->id], ['confirm' => __('Are you sure you want to delete # {0}?', $users->id), 'class' => 'btn btn-danger']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Stats') ?></h4>
        <?php if (!empty($vendor->stats)): ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Date') ?></th>
                    <th scope="col"><?= __('Vendor Id') ?></th>
                    <th scope="col"><?= __('Total Domains') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($vendor->stats as $stats): ?>
                <tr>
                    <td><?= h($stats->id) ?></td>
                    <td><?= h($stats->date) ?></td>
                    <td><?= h($stats->vendor_id) ?></td>
                    <td><?= h($stats->total_domains) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['controller' => 'Stats', 'action' => 'view', $stats->id], ['class' => 'btn btn-secondary']) ?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'Stats', 'action' => 'edit', $stats->id], ['class' => 'btn btn-secondary']) ?>
                        <?= $this->Form->postLink( __('Delete'), ['controller' => 'Stats', 'action' => 'delete', $stats->id], ['confirm' => __('Are you sure you want to delete # {0}?', $stats->id), 'class' => 'btn btn-danger']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>
