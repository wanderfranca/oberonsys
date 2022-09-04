<?php echo $this->extend('Layout/principal') ?>

<?php echo $this->section('titulo') ?> <?php echo $titulo; ?><?php $this->endSection() ?>

<!-- Estilos -->
<?php echo $this->section('estilos') ?>
<?php $this->endSection() ?>

<!-- Conteúdo -->
<?php echo $this->section('conteudo') ?>

<div class="row">

    <?php if($forma->id == 1): ?>
    <div class="col-md-12">
        <div class="alert alert-warning" role="alert">
            <h4 class="alert-heading">Importante!</h4>
            <p>Esta forma de pagamento <b><?php echo esc($forma->nome) ?></b> não pode ser editada ou excluída, pois a mesma é base do sistema</p>
            <hr>
            <p class="mb-0">Não se preocupe, em caso de dúvidas entre em contato conosco.</p>
        </div>
    </div>
    <?php endif; ?>

    <?php if($forma->id == 2): ?>
    <div class="col-md-12">
        <div class="alert alert-warning" role="alert">
            <h4 class="alert-heading">Importante!</h4>
            <p>Esta forma de pagamento <b><?php echo esc($forma->nome) ?></b> não pode ser editada ou excluída, pois a mesma é utilizada para ordem de serviços que não geram valor financeiro</p>
            <hr>
            <p class="mb-0">Não se preocupe, em caso de dúvidas entre em contato conosco.</p>
        </div>
    </div>
    <?php endif; ?>

    <div class="col-lg-4">

        <div class="user-block block">
    
            <h5 class="card-title mt-2"><?php echo esc($forma->nome);?></h5> 
            <p class="contributions mt-0"><?php echo $forma->exibeSituacao(); ?></p>
            <p class="card-text"><?php echo esc($forma->descricao); ?></p>
            <p class="card-text">Criado <?php echo date('d-m-Y', strtotime($forma->criado_em)); ?></p>
            <p class="card-text">Atualizado <?php echo date('d-m-Y', strtotime($forma->atualizado_em));?></p>

            <?php if($forma->id > 2): ?>

            <!-- Example single danger button -->
            <div class="btn-group">
                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Ações
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?php echo site_url("formas/editar/$forma->id"); ?>">
                    Editar forma de pagamento
                    </a>

                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="<?php echo site_url("formas/excluir/$forma->id"); ?>">
                    Excluir forma de pagamento
                    </a>

                </div>

            </div>

            <?php endif; ?>


            <a href="<?php echo site_url("formas") ?>" class="btn btn-secondary btn-sm">Voltar</a>

        </div> <!-- FIM DO DIV BLOCK -->

    </div>

</div>




<?php $this->endSection() ?>

<!-- Scripts -->
<?php echo $this->section('scripts') ?>
<?php $this->endSection() ?>