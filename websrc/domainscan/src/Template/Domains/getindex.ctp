<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('name') ?></th>
        <th scope="col"><?= $this->Paginator->sort('errors') ?></th>
        <th scope="col"><?= $this->Paginator->sort('new_mx') ?></th>
        <th scope="col"><?= $this->Paginator->sort('vendor_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('note') ?></th>
        <th scope="col"><?= $this->Paginator->sort('created') ?></th>
        <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($domains as $domain): ?>
        <tr>
            <td><?= $this->Number->format($domain->id) ?></td>
            <td><?= h($domain->name) ?></td>
            <td><?= $this->Number->format($domain->errors) ?></td>
            <td><?= h($domain->new_mx) ?></td>
            <td><?= $domain->has('vendor') ? $this->Html->link($domain->vendor->name, ['controller' => 'Vendors', 'action' => 'view', $domain->vendor->id]) : '' ?></td>
            <td><?= h($domain->note) ?></td>
            <td><?= h($domain->created) ?></td>
            <td><?= h($domain->modified) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $domain->id], ['title' => __('View'), 'class' => 'btn btn-secondary']) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $domain->id], ['title' => __('Edit'), 'class' => 'btn btn-secondary']) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $domain->id], ['confirm' => __('Are you sure you want to delete # {0}?', $domain->id), 'title' => __('Delete'), 'class' => 'btn btn-danger']) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
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
