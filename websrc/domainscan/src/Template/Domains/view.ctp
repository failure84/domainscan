<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Domain'), ['action' => 'edit', $domain->id]) ?> </li>
        <li><?= $this->Html->link(__('List Vendors'), ['controller' => 'Vendors', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('List Domains'), ['action' => 'index']) ?> </li>
    </ul>
</nav>
<div class="domains view large-9 medium-8 columns content">
    <h3><?= h($domain->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($domain->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= h($domain->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Errors') ?></th>
            <td><?= $this->Number->format($domain->errors) ?></td>
        </tr>
        <tr>
            <th><?= __('Note') ?></th>
            <td><?= h($domain->note) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($domain->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($domain->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Domains Records') ?></h4>
        <?php if (!empty($domain->domains_records)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Vendor') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Priority') ?></th>
                <th><?= __('Type') ?></th>
                <th><?= __('First Time Scanned') ?></th>
                <th><?= __('Last In Use') ?></th>
            </tr>
            <?php foreach ($domain->domains_records as $domainsRecords): ?>
            <tr>
		<td><?= $domainsRecords->has('vendor') ? $this->Html->link($domainsRecords->vendor->name, ['controller' => 'Vendors', 'action' => 'view', $domainsRecords->vendor->id]) : '' ?></td>
                <td><?= $this->Text->tail($domainsRecords->name, 20) ?></td>
                <td><?= h($domainsRecords->value) ?></td>
                <td><?= h($domainsRecords->type) ?></td>
                <td><?= h($domainsRecords->created) ?></td>
                <td><?= h($domainsRecords->modified) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
