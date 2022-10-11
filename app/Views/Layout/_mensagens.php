<?php if(session()->has('sucesso')): ?>

<div class="alert alert-success alert-dismissible fade show closealert" role="alert">
    <strong>Tudo certo!</strong> <?php echo session('sucesso') ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<?php endif; ?>

<?php if(session()->has('sucesso_pause')): ?>

<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Tudo certo!</strong> <?php echo session('sucesso_pause') ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<?php endif; ?>

<?php if(session()->has('info')): ?>

<div class="alert alert-info alert-dismissible fade show" role="alert">
    <strong>Informação: </strong> <?php echo session('info') ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<?php endif; ?>

<?php if(session()->has('atencao')): ?>

<div class="alert alert-warning alert-dismissible fade show closealert" role="alert">
    <strong><i class="fa fa-exclamation-triangle"> </i> Atenção!</strong> <?php echo session('atencao') ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<?php endif; ?>

<!-- POST SEM AJAX -->
<?php if(session()->has('erros_model')): ?>
<ul>
    <?php foreach(session('erros_model') as $erro): ?>

        <li class="text-danger"><?php echo $erro; ?></li>

    <?php endforeach; ?>

</ul>
<?php endif; ?>

<!-- Erro -->
<?php if(session()->has('error')): ?>

<div id="alert-danger" class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong><i class="fa fa-exclamation-circle fa-2x text-white"></i></strong> <?php echo session('error') ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<?php endif; ?>

<?php if(session()->has('msgLogout')): ?>

<div class="alert alert-success alert-dismissible fade show closealert" role="alert">
    <?php echo session('msgLogout') ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<?php endif; ?>

<?php if(session()->has('bem-vindo')): ?>

<div class="alert alert-success alert-dismissible fade show closealert" role="alert">
    <?php echo session('bem-vindo') ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<?php endif; ?>
