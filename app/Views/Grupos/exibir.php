<?php echo $this->extend('Layout/principal') ?>

<?php echo $this->section('titulo') ?> <?php echo $titulo; ?><?php $this->endSection() ?>

<!-- Estilos -->
<?php echo $this->section('estilos') ?>
<?php $this->endSection() ?>

<!-- Conteúdo -->
<?php echo $this->section('conteudo') ?>

<div class="row">

    <?php if($grupo->id < 3): ?>
    <div class="col-md-12">
        <div class="alert alert-warning" role="alert">
            <h4 class="alert-heading">Importante!</h4>
            <p>O grupo <b><?php echo esc($grupo->nome) ?></b> não pode ser editado ou excluído, pois não podem ter suas
                permissões revogadas</p>
            <hr>
            <p class="mb-0">Não se preocupe, em caso de dúvidas, chame a gente no suporte =D</p>
        </div>
    </div>
    <?php endif; ?>

    <div class="col-lg-4">

        <div class="user-block block">
    
            <h5 class="card-title mt-2"><?php echo esc($grupo->nome);?></h5> 
            <p class="contributions mt-0"><?php echo $grupo->exibeSituacao(); ?>

                <!-- Se o grupo não estiver deletado, então apresente o popover abaixo -->
                <?php if($grupo->deletado_em == null): ?>

                <a tabindex="0" style="text-decoration: none;" class="" role="button" data-toggle="popover"
                    data-trigger="focus" title="Importante"
                    data-content="Esse grupo <?php echo ($grupo->exibir == true ? 'será' : 'não será'); ?> exibido como opção na hora de definir um <b class='text-primary'>Responsável técnico</b> pela ordem de serviço">&nbsp;&nbsp;<i
                        class="fa fa-question-circle fa-lg text-warning"></i></a>

                <?php endif; ?>

            </p>
            <p class="card-text"><?php echo esc($grupo->descricao); ?></p>
            <p class="card-text">Criado <?php echo $grupo->criado_em->humanize(); ?></p>
            <p class="card-text">Atualizado <?php echo $grupo->atualizado_em->humanize();?></p>

            <?php if($grupo->id > 2): ?>

            <!-- Example single danger button -->
            <div class="btn-group">
                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Ações
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?php echo site_url("grupos/editar/$grupo->id"); ?>">Editar grupo de
                        acesso</a>

                        <?php if($grupo->id > 2): ?>

                            <a class="dropdown-item" href="<?php echo site_url("grupos/permissoes/$grupo->id"); ?>">Permissões do Grupo</a>

                        <?php endif; ?>

                    <div class="dropdown-divider"></div>

                    <?php if($grupo->deletado_em == null): ?>
                    <a class="dropdown-item" href="<?php echo site_url("grupos/excluir/$grupo->id"); ?>">Excluir grupo
                        de acesso</a>

                    <?php else:  ?>
                    <a class="dropdown-item"
                        href="<?php echo site_url("grupos/desfazerexclusao/$grupo->id"); ?>">Restaurar grupo de
                        acesso</a>

                    <?php endif;  ?>

                </div>

            </div>

            <?php endif; ?>


            <a href="<?php echo site_url("grupos") ?>" class="btn btn-secondary btn-sm">Voltar</a>

        </div> <!-- FIM DO DIV BLOCK -->

    </div>

</div>




<?php $this->endSection() ?>

<!-- Scripts -->
<?php echo $this->section('scripts') ?>
<?php $this->endSection() ?>