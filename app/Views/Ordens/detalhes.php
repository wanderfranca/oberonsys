<?php echo $this->extend('Layout/principal') ?>

<?php echo $this->section('titulo') ?> <?php echo $titulo; ?><?php $this->endSection() ?>

<!-- Estilos -->
<?php echo $this->section('estilos') ?>
<?php $this->endSection() ?>

<!-- Conteúdo -->
<?php echo $this->section('conteudo') ?>

<div class="row">

    <div class="col-lg-12">

        <div class="block">

            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                        aria-controls="pills-home" aria-selected="true">Detalhes</a>
                </li>
                <?php if(isset($ordem->transacao)): ?>
                <li class="nav-item">
                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
                        aria-controls="pills-profile" aria-selected="false">Transações</a>
                </li>
                <?php endif; ?>
            </ul>
            <!-- DETALHES -->
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="user-block text-center">

                        <div class="user-title mb-4">
                            <h5 class="card-title mt-2"><?php echo esc($ordem->nome);?></h5>
                            <span>Tag: <?php echo esc($ordem->codigo); ?></span>
                        </div>

                        <p class="contributions mt-0"><?php echo $ordem->exibeSituacao(); ?></p>
                        <p class="contributions mt-0 text-white"><b>Aberta por:</b> <?php echo esc($ordem->usuario_abertura); ?></p>

                        <?php if($ordem->usuario_responsavel !== null): ?>
                        <p class="contributions mt-0 text-white"><b>Técnico:</b> <?php echo $ordem->usuario_responsavel; ?></p>

                        <?php else: ?>
                    <p class="contributions mt-0">Técnico: Sem técnico definido</p>
                        <?php endif; ?>

                        <?php if($ordem->situacao === 'encerrada'): ?>
                        <p class="contributions mt-0">Encerrada por: <?php echo esc($ordem->usuario_encerramento); ?>
                        </p>
                        <?php endif; ?>

                        <p class="card-text">Criado em: <?php echo date("d/m/Y H:m",strtotime($ordem->criado_em)); ?>
                        </p>
                        <p class="card-text">Atualizado em: <?php echo date("d/m/Y H:m",strtotime($ordem->atualizado_em));?></p>

                        <hr class="border-secondary">

                        <?php if($ordem->itens === null):?>
                        <div class="contributions py-3">

                            <p>Nenhum item foi adicionado à esta OS</p>
                        </div>
                        <?php if($ordem->situacao === 'aberta'): ?>

                        <a class="btn btn-outline-primary btn-sm"
                            href="<?php echo site_url("ordensitens/itens/$ordem->codigo") ?>">Adicionar itens</a>

                        <?php endif; ?>

                    </div>


                    <?php else: ?>

                    <!-- DIV - TABLE ITENS -->
                    <div class="row container-fluid">

                        <div class="col-lg-12">

                            <div class="table-responsive text-left">

                                <table class="table table-borderless table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th scope="col">Item</th>
                                            <th scope="col">Tipo</th>
                                            <th scope="col">Preço</th>
                                            <th scope="col">Qtde.</th>
                                            <th scope="col">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                    
                                        $valorProdutos = 0;
                                        $valorServicos = 0;
                                    
                                    ?>

                                        <?php foreach($ordem->itens as $item): 
                            
                                        if($item->tipo === 'produto')
                                            {
                                                $valorProdutos += $item->preco_total_vendido;
                                            
                                            } else
                                            {
                                                $valorServicos += $item->preco_total_vendido;
                                            }
                                        
                                        ?>
                                        <tr>
                                            <!-- 0 Item -->
                                            <th scope="row"><?php echo ellipsize($item->nome, 30); ?></th>
                                            <!-- 1 Tipo -->
                                            <td><?php echo esc(ucfirst($item->tipo)); ?></td>
                                            <!-- 2 Preço do item vendido -->
                                            <td>R$ <?php echo esc(number_format($item->preco_vendido, 2)); ?></td>
                                            <!-- 3 Quantidade de itens -->
                                            <td> <?php echo $item->item_quantidade; ?></td>
                                            <!-- 4 Preço que foi vendido -->
                                            <td>R$ <?php echo esc(number_format($item->preco_total_vendido, 2)) ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <td class="text-right font-weight-bold" colspan="4">
                                                <label class="text-white mr-3"> Valor Produtos: </label>
                                            </td>

                                            <td class="font-weight-bold">R$
                                                <?php echo esc(number_format($valorProdutos, 2)); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-right font-weight-bold" colspan="4">
                                                <label class="text-white mr-3"> Valor Serviços: </label>
                                            </td>

                                            <td class="font-weight-bold">R$
                                                <?php echo esc(number_format($valorServicos, 2)); ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="text-right font-weight-bold" colspan="4">
                                                <label class="text-white mr-3"> Valor Desconto: </label>
                                            </td>
                                            <td class="font-weight-bold">
                                                R$ <?php echo esc(number_format($ordem->valor_desconto, 2)); ?>
                                            </td>

                                        </tr>

                                        <tr>
                                            <td class="text-right font-weight-bold" colspan="4">
                                                <label class="text-white mr-3"> Valor Total da Ordem: </label>
                                            </td>
                                            <td class="font-weight-bold">
                                                R$ <?php echo esc(number_format($valorServicos + $valorProdutos, 2)); ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="text-right font-weight-bold" colspan="4">
                                                <label class="text-white mr-3"> Valor Total: </label>
                                            </td>
                                            <td class="font-weight-bold">
                                                R$ <?php 
                                                
                                                        $valorItens = $valorServicos + $valorProdutos;        
                                                        echo esc(number_format($valorItens - $ordem->valor_desconto, 2)); 
                                                        
                                                    ?>
                                            </td>
                                        </tr>

                                    </tfoot>

                                </table>
                            </div>
                        </div>

                        <?php endif; ?>
                    </div>

                </div>
                <?php if(isset($ordem->transacao)): ?>
                <!-- TRANSACOES -->
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    TRANSAÇÕES DA ORDEM
                </div>

            </div>
            <?php endif; ?>



            <!-- Example single danger button -->
            <div class="btn-group mt-5">
                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Ações
                </button>
                <div class="dropdown-menu">

                    <?php if($ordem->situacao === 'aberta'): ?>

                    <a class="dropdown-item" href="<?php echo site_url("ordens/editar/$ordem->codigo"); ?>">Editar</a>
                    <a class="dropdown-item" href="<?php echo site_url("ordens/responsavel/$ordem->codigo"); ?>">Definir
                        técnico responsável</a>
                    <a class="dropdown-item"
                        href="<?php echo site_url("ordensitens/itens/$ordem->codigo"); ?>">Gerenciar itens</a>
                    <a class="dropdown-item"
                        href="<?php echo site_url("ordens/encerrar/$ordem->codigo"); ?>">Encerrar</a>
                    <?php endif;  ?>

                    <a class="dropdown-item"
                        href="<?php echo site_url("ordensevidencias/evidencias/$ordem->codigo"); ?>">Evidências da
                        Ordem</a>

                    <a class="dropdown-item" href="<?php echo site_url("ordens/email/$ordem->codigo"); ?>">Enviar por
                        e-mail</a>
                    <a class="dropdown-item" href="<?php echo site_url("ordens/gerarpdf/$ordem->codigo"); ?>">Gerar
                        PDF</a>


                    <?php if($ordem->deletado_em === null): ?>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo site_url("ordens/excluir/$ordem->codigo"); ?>">Excluir</a>

                    <?php else:  ?>
                    <a class="dropdown-item"
                        href="<?php echo site_url("ordens/desfazerexclusao/$ordem->codigo"); ?>">Restaurar O.S</a>

                    <?php endif;  ?>

                </div>
            </div>

            <a href="<?php echo site_url('ordens')?>" class="btn btn-secondary btn-sm ml-2 mt-5">Voltar</a>

        </div> <!-- FIM DO DIV BLOCK -->

    </div>
</div>


<?php $this->endSection() ?>

<!-- Scripts -->
<?php echo $this->section('scripts') ?>
<?php $this->endSection() ?>