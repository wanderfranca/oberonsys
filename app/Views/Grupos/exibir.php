<?php echo $this->extend('Layout/principal') ?>

<?php echo $this->section('titulo') ?> <?php echo $titulo; ?><?php $this->endSection() ?>

<!-- Estilos -->
<?php echo $this->section('estilos') ?>
<?php $this->endSection() ?>

<!-- Conteúdo -->
<?php echo $this->section('conteudo') ?>

<div class="row">

    <div class="col-lg-3 text-center">

        <div class="user-block block">

            <h5 class="card-title mt-2"><?php echo esc($grupo->nome);?></h5>
            <p class="contributions mt-0"><?php echo $grupo->exibeSituacao(); ?></p>
            <p class="card-text"><?php echo esc($grupo->descricao); ?></p>
            <p class="card-text">Criado <?php echo $grupo->criado_em->humanize(); ?></p>
            <p class="card-text">Atualizado <?php echo $grupo->atualizado_em->humanize();?></p>

            <!-- Example single danger button -->
            <div class="btn-group">
                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    Ações
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?php echo site_url("grupos/editar/$grupo->id"); ?>">Editar grupo de acesso</a>
                    <div class="dropdown-divider"></div>

                    <?php if($grupo->deletado_em == null): ?>
                    <a class="dropdown-item" href="<?php echo site_url("grupos/excluir/$grupo->id"); ?>">Excluir grupo de acesso</a>

                    <?php else:  ?>
                        <a class="dropdown-item" href="<?php echo site_url("grupos/desfazerexclusao/$grupo->id"); ?>">Restaurar grupo de acesso</a>

                    <?php endif;  ?>

                </div>
            </div>

            <a href="<?php echo site_url("grupos") ?>" class="btn btn-secondary btn-sm ml-2">Voltar</a>

        </div> <!-- FIM DO DIV BLOCK -->

    </div>

</div>




<?php $this->endSection() ?>

<!-- Scripts -->
<?php echo $this->section('scripts') ?>
<?php $this->endSection() ?>