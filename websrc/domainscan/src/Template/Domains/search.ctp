<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Login'), ['controller' => 'login', 'action' => 'login']) ?> </li>
    </ul>
</nav>
<div class="domains view large-9 medium-8 columns content">
    <h3><?= __('Search') ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Domain') ?></th>
            <td>
		<?= $this->Form->create() ?>
		<?= $this->Form->input('domain') ?>
		<?= $this->Form->button('Search') ?>
		<?= $this->Form->end() ?>
	    </td>
        </tr>
    </table>
</div>
