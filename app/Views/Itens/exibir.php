<?php echo $this->extend('Layout/principal') ?>

<?php echo $this->section('titulo') ?> <?php echo $titulo; ?><?php $this->endSection() ?>

<!-- Estilos -->
<?php echo $this->section('estilos') ?>
<?php $this->endSection() ?>

<!-- Conteúdo -->
<?php echo $this->section('conteudo') ?>

<div class="row">

    <div class="col-lg-5">

        <div class="user-block block">
            <div class="text-center">

                <?php  if($item->imagem == null): ?>

                <img src="<?php echo site_url('recursos/img/item_sem_imagem.png'); ?>" class="card-img-top"
                    style="width: 90%;" alt="Usuário sem imagem">

                <?php else: ?>

                <img src="<?php echo site_url("itens/imagem/$item->imagem"); ?>" class="card-img-top"
                    style="width: 90%;" alt="<?php echo esc($item->nome);?>">

                <?php endif; ?>

                <a href="<?php echo site_url("items/editarimagem/$item->id") ?>" class="btn btn-outline-primary btn-sm mt-2">Alterar imagem</a>
            </div>
            <hr class="border-secondary">
            <h5 class="card-title mt-2 text-center"><?php echo esc($item->nome);?></h5>
            <p class="contributions mt-0"><?php echo $item->exibeTipo(); ?></p>
            <p class="contributions mt-0">Estoque: <?php echo $item->exibeEstoque(); ?></p>
            <p class="contributions mt-0"><?php echo $item->exibeSituacao(); ?></p>

            <p class="card-text">Criado em:  <?php echo date('d/m/Y H:m',strtotime($item->criado_em)); ?></p>
            <p class="card-text">Atualizado em: <?php echo $item->atualizado_em->humanize();?></p>

            <!-- Example single danger button -->
            <div class="btn-group">
                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    Opções
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?php echo site_url("items/editar/$item->id"); ?>">Editar</a>
                    <a class="dropdown-item" target="_blank" href="<?php echo site_url("itens/codigobarras/$item->id") ?>">Gerar Código de Barras</a>
                    
                    <div class="dropdown-divider"></div>

                    <?php if($item->deletado_em == null): ?>
                    <a class="dropdown-item" href="<?php echo site_url("items/excluir/$item->id"); ?>">Excluir</a>

                    <?php else:  ?>
                        <a class="dropdown-item" href="<?php echo site_url("items/desfazerexclusao/$item->id"); ?>">Restaurar</a>

                    <?php endif;  ?>

                </div>
            </div>

            <a href="<?php echo site_url("item") ?>" class="btn btn-secondary btn-sm ml-2">Voltar</a>

        </div> <!-- FIM DO DIV BLOCK -->

    </div>

</div>




<?php $this->endSection() ?>

<!-- Scripts -->
<?php echo $this->section('scripts') ?>
<?php $this->endSection() ?>