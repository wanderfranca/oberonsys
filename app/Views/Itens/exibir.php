<?php echo $this->extend('Layout/principal') ?>

<?php echo $this->section('titulo') ?> <?php echo $titulo; ?><?php $this->endSection() ?>

<!-- Estilos -->
<?php echo $this->section('estilos') ?>
<?php $this->endSection() ?>

<!-- Conteúdo -->
<?php echo $this->section('conteudo') ?>

<div class="row">

    <div class="col-lg-4">

        <div class="user-block block">

            <?php if($item->tipo === 'produto'): ?>

            <div class="text-center">

                <?php  if($item->imagem == null): ?>

                <img src="<?php echo site_url('recursos/img/item_sem_imagem.png'); ?>" class="card-img-top"
                    style="width: 90%;" alt="Usuário sem imagem">

                <?php else: ?>

                <img src="<?php echo site_url("itens/imagem/$item->imagem"); ?>" class="card-img-top"
                    style="width: 90%;" alt="<?php echo esc($item->nome);?>">

                <?php endif; ?>
                <a href="<?php echo site_url("itens/editarimagem/$item->id") ?>"
                    class="btn btn-outline-primary btn-sm mt-2">Alterar imagem</a>

            </div>
            <hr class="border-secondary">

            <?php endif; ?>

            <h5 class="card-title mt-2 mb-3 text-center text-white"><?php echo esc($item->nome);?></h5>
            <p class="contributions mt-0"><?php echo $item->exibeTipo(); ?></p>
            <p class="contributions mt-0">Estoque: <?php echo $item->exibeEstoque(); ?></p>
            <p class="contributions mt-0"><?php echo $item->exibeSituacao(); ?></p>

            <p class="card-text">Criado em: <?php echo date('d/m/Y H:m',strtotime($item->criado_em)); ?></p>
            <p class="card-text">Atualizado em: <?php echo $item->atualizado_em->humanize();?></p>

            <!-- Example single danger button -->
            <div class="btn-group">
                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Opções
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?php echo site_url("itens/editar/$item->id"); ?>">Editar</a>
                    <a class="dropdown-item" target="_blank"
                        href="<?php echo site_url("itens/codigobarras/$item->id") ?>">Gerar Código de Barras</a>

                    <div class="dropdown-divider"></div>

                    <?php if($item->deletado_em == null): ?>
                    <a class="dropdown-item" href="<?php echo site_url("itens/excluir/$item->id"); ?>">Excluir</a>

                    <?php else:  ?>
                    <a class="dropdown-item"
                        href="<?php echo site_url("itens/desfazerexclusao/$item->id"); ?>">Restaurar</a>

                    <?php endif;  ?>

                </div>
            </div>

            <a href="<?php echo site_url('itens')?>" class="btn btn-secondary btn-sm ml-2">Voltar</a>

        </div> <!-- FIM DO DIV BLOCK -->

    </div>


    <div class="col-lg-8">

        <div class="user-block block">

            <h2 class="contributions d-flex align-items-center justify-content-center text-white">Histórico de
                alterações do item</h2>

            <?php if(isset($item->historico) === false): ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-sm table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <p>
                                <span class="text-dark d-flex align-items-center justify-content-center">Ainda não
                                    houve alterações no
                                    cadastro deste item</spam>
                            </p>
                        </tr>
                    </thead>
                    <?php else: ?>
                    <tbody>
                        <div id="accordion">
                            <?php foreach($item->historico as $key => $historico): ?>
                            <tr>
                                <td>
                                    <div class="card">
                                        <div class="card-header" id="heading-<?php echo $key;?>">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" data-toggle="collapse"
                                                    data-target="#collapse-<?php echo $key;?>" aria-expanded="true"
                                                    aria-controls="collapse-<?php echo $key;?>">
                                                    <b class="text-dark"><?php echo esc($historico['acao']) ?>
                                                    </b><?php echo date('d/m/Y H:i', strtotime($historico['criado_em']))?>
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapse-<?php echo $key;?>"
                                            class="collapse <?php echo($key === 0 ? 'show' : ''); ?>"
                                            aria-labelledby="heading-<?php echo $key;?>" data-parent="#accordion">
                                            <div class="card-body">

                                                <p><b class="text-dark">Usuário: </b>
                                                    <?php echo $historico['nome_usuario'] ?></p>
                                                <?php foreach($historico['atributos_alterados'] as $evento): ?>
                                                <p><?php echo $evento ?></p>
                                </td>
                            </tr>

                            <?php endforeach; ?>

                        </div>


            </div>

        </div>

        <?php endforeach; ?>
        </tbody>
        </tbody>
        </table>
        <div class="mt-3 ml-1">
            <?php echo $item->pager->links(); ?>
        </div>

        <!-- /div -- Fim acordion  -->
    </div>
</div>
</div>
</div>

<?php endif; ?>



</div>





<?php $this->endSection() ?>

<!-- Scripts -->
<?php echo $this->section('scripts') ?>
<?php $this->endSection() ?>