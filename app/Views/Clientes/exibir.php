<?php echo $this->extend('Layout/principal') ?>

<?php echo $this->section('titulo') ?> <?php echo $titulo; ?><?php $this->endSection() ?>

<!-- Estilos -->
<?php echo $this->section('estilos') ?>
<?php $this->endSection() ?>

<!-- Conteúdo -->
<?php echo $this->section('conteudo') ?>

<div class="row">

    <div class="col-lg-6">
        <div class="user-block block">
            <h5 class="card-title mt-2 text-white"><?php echo esc($cliente->nome);?></h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item bgblock">
                    <p class="card-text"><b>CPF: </b> <?php echo esc($cliente->cpf); ?></p>
                </li>
                <li class="list-group-item bgblock">
                    <p class="card-text"><b>Telefone:</b> <?php echo esc($cliente->telefone); ?></p>
                </li>
                <li class="list-group-item bgblock">
                    <p class="card-text"><b>E-mail: </b><?php echo esc($cliente->email); ?></p>
                </li>
                <?php if($cliente->endereco == true): ?>
                <li class="list-group-item bgblock mr-5">
                    <p class="card-text">
                    <div class="accordion" id="accordionEnderco">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse"
                                        data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <i class="fa fa-map-marker" aria-hidden="true"></i> Endereço Completo
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                data-parent="#accordionEnderco">
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item bgblock">
                                            <p class="card-text"><b>Rua: </b>
                                                <?php echo esc($cliente->endereco)?><?php echo ((', '.$cliente->numero) ? : ''); ?>
                                            </p>
                                        </li>
                                        <li class="list-group-item bgblock">
                                            <p class="card-text"><b>Bairro: </b><?php echo esc($cliente->bairro); ?></p>
                                        </li>
                                        <li class="list-group-item bgblock">
                                            <p class="card-text"><b>Cidade:
                                                </b><?php echo esc($cliente->cidade).' - <b>UF</b>: '. esc($cliente->estado) ?>
                                            </p>
                                        </li>
                                        <li class="list-group-item bgblock">
                                            <p class="card-text"><b>CEP: </b><?php echo esc($cliente->cep); ?></p>
                                        </li>
                                        <li class="list-group-item bgblock">
                                            <p class="card-text"><b>Complemento:: </b><?php echo esc($cliente->complemento); ?></p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                </li>
                <?php endif; ?>
                <li class="list-group-item bgblock">
                    <p class="card-text"><?php echo $cliente->exibeSituacao(); ?></p>
                </li>
                <li class="list-group-item bgblock">
                    <p class="card-text"><b>Criado: </b><?php echo $cliente->criado_em->humanize() .' / <b>Atualizado: </b>'. $cliente->atualizado_em->humanize(); ?></p>
                </li>

            </ul>

            <!-- Example single danger button -->
            <div class="btn-group mt-3">
                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Ações
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?php echo site_url("clientes/editar/$cliente->id"); ?>">Editar cliente</a>
                    <a class="dropdown-item" href="<?php echo site_url("clientes/historico/$cliente->id"); ?>">Histórico</a>

                    <div class="dropdown-divider"></div>

                    <?php if($cliente->deletado_em == null): ?>
                    <a class="dropdown-item" href="<?php echo site_url("clientes/excluir/$cliente->id"); ?>"><b class="text-danger">Excluir cliente</b></a>

                    <?php else:  ?>
                    <a class="dropdown-item"
                        href="<?php echo site_url("clientes/desfazerexclusao/$cliente->id"); ?>">Restaurar cliente</a>

                    <?php endif;  ?>

                </div>
            </div>

            <a href="<?php echo site_url("clientes") ?>" class="btn btn-secondary btn-sm ml-2 mt-3">Voltar</a>

        </div> <!-- FIM DO DIV BLOCK -->

    </div>

</div>




<?php $this->endSection() ?>

<!-- Scripts -->
<?php echo $this->section('scripts') ?>
<?php $this->endSection() ?>