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
            <h5 class="card-title mt-2 text-white"><?php echo 'Situação da conta: ' . ($conta->situacao == 0 ? '<b> EM ABERTO' : 'PAGA </b>' ); ?></h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item bgblock">
                    <p class="card-text"><b>CNPJ: </b> <?php echo esc($conta->cnpj); ?></p>
                </li>
                <li class="list-group-item bgblock">
                    <p class="card-text"><b>Despesa:</b> <?php echo esc($conta->despesa_nome); ?></p>
                </li>

                <li class="list-group-item bgblock mr-5">
                    <p class="card-text">
                    <div class="accordion" id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse"
                                        data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <i class="fa fa-map-marker" aria-hidden="true"></i> Detalhes gerais
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item bgblock">
                                            <p class="card-text"><b class="text-white">Descrição: </b><?php echo esc($conta->descricao_conta)?> &nbsp; <b class="text-white">Despesa: </b><?php echo esc($conta->despesa_nome); ?>
                                            </p>
                                        </li>
                                        <li class="list-group-item bgblock">
                                            <p class="card-text"><b class="text-white">Documento: </b> <?php echo esc($conta->tipo_documento_nome); ?> &nbsp;<b class="text-white">N°: </b><?php echo esc($conta->numero_documento); ?> &nbsp; <b class="text-white"> Data de Vencimento: </b><?php echo date('d-m-Y', strtotime($conta->data_vencimento)); ?></p>
                                        </li>

                                         <li class="list-group-item bgblock">
                                            <p class="card-text"><b class="text-white">Situação: </b><?php echo $conta->exibeSituacao(); ?></p>
                                        </li>

                                        <li class="list-group-item bgblock">
                                            <p class="card-text"><b class="text-white">Valor: </b><?php echo 'R$ ' . esc(number_format($conta->valor_conta, 2)); ?></p>
                                        </li>

                                        <li class="list-group-item bgblock">
                                            <p class="card-text"><b class="text-white">Lançado por: </b><?php echo esc($conta->usuario); ?></p>
                                        </li>
  
                                    </ul>
                                </div>
                            </div>
                        </div>
                </li>
      
                
                <li class="list-group-item bgblock">
                    <p class="card-text"><?php echo $conta->exibeSituacao();  echo ( $conta->situacao == 1 ? '<b class="text-white"> EM: '.date('d-m-Y', strtotime($conta->data_pagamento)).'</b>' : '')?></p>
                </li>
                <li class="list-group-item bgblock">
                    <p class="card-text float-md-right"><b>Criado em: </b><?php echo date('d-m-Y', strtotime($conta->criado_em)) .' / <b>Atualizado: </b>'. date('d-m-Y', strtotime($conta->atualizado_em)); ?></p>
                </li>
            </ul>
            
            <!-- Example single danger button -->
            <div class="btn-group mt-3">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" adata-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Ações
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?php echo site_url("cpagar/editar/$conta->id"); ?>">Editar conta</a>
                    <div class="dropdown-divider"></div>

                    <?php if($conta->deletado_em == null): ?>
                    <a class="dropdown-item" href="<?php echo site_url("cpagar/excluir/$conta->id"); ?>"><b class="text-danger">Excluir conta</b></a>

                    <?php else:  ?>
                    <a class="dropdown-item"
                        href="<?php echo site_url("cpagar/desfazerexclusao/$conta->id"); ?>">Restaurar conta</a>

                    <?php endif;  ?>

                </div>
            </div>

            <a href="<?php echo site_url("cpagar") ?>" class="btn btn-secondary btn-sm ml-2 mt-3">Voltar</a>

        </div> <!-- FIM DO DIV BLOCK -->

    </div>

</div>




<?php $this->endSection() ?>

<!-- Scripts -->
<?php echo $this->section('scripts') ?>

<script>$('.dropdown-toggle').dropdown() </script>

<?php $this->endSection() ?>