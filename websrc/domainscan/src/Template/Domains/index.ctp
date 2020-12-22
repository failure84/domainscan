<script type="text/javascript">
    $.ajax({
        method: 'get',
        url: "<?= $this->Url->build(['controller' => 'domains', 'action' => 'getindex', 'q' => $this->request->getQuery('q')]) ?>",
        success: function(response) {
            console.log('got domains');
            $('.loading').hide();
            $('.getindex').html(response);
            $('.getindex').show();
        }
    })

    $(document).on('click', '.getindex th a', function(e) {
        e.preventDefault();
        console.log('click');
        $('.getindex').hide();
        $('.loading').show();

        var target = $(this).attr('href');

        $.get(target, function(data) {
            $('.getindex').html(data);
            $('.loading').hide();
            $('.getindex').show();
        }, 'html')
    });
    
</script>
<?php $this->extend('../Layout/TwitterBootstrap/dashboard'); ?>
<?php $this->start('tb_actions'); ?>
<li><?= $this->Html->link(__('New Domain'), ['action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Vendors'), ['controller' => 'Vendors', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Vendor'), ['controller' => 'Vendors', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('List Domains Records'), ['controller' => 'DomainsRecords', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
<li><?= $this->Html->link(__('New Domains Record'), ['controller' => 'DomainsRecords', 'action' => 'add'], ['class' => 'nav-link']) ?></li>
<?php $this->end(); ?>
<?php $this->assign('tb_sidebar', '<ul class="nav flex-column">' . $this->fetch('tb_actions') . '</ul>'); ?>

<div class="spinner-border loading" role="status">
  <span class="sr-only">Loading...</span>
</div>
<div class="getindex">
</div>