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

            <div class="user-block text-center">
                <!-- Div user block text center -->

                <div id="accordion">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0 text-left">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne"
                                    aria-expanded="true" aria-controls="collapseOne">
                                    Detalhes da Ordem
                                </button>
                            </h5>
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                            data-parent="#accordion">
                            <div class="card-body">
                                <div class="user-title mb-4">
                                    <h5 class="card-title mt-2"><?php echo esc($ordem->nome);?></h5>
                                    <span>Tag: <?php echo esc($ordem->codigo); ?></span>
                                </div>

                                <p class="contributions mt-0"><?php echo $ordem->exibeSituacao(); ?></p>
                                <p class="contributions mt-0 text-white"><b>Aberta por:</b>
                                    <?php echo esc($ordem->usuario_abertura); ?></p>

                                <?php if($ordem->usuario_responsavel !== null): ?>
                                <p class="contributions mt-0 text-white"><b>Técnico:</b>
                                    <?php echo $ordem->usuario_responsavel; ?></p>

                                <?php else: ?>
                                <p class="contributions mt-0">Técnico: Sem técnico definido</p>
                                <?php endif; ?>

                                <?php if($ordem->situacao === 'encerrada'): ?>
                                <p class="contributions mt-0">Encerrada por:
                                    <?php echo esc($ordem->usuario_encerramento); ?>
                                </p>
                                <?php endif; ?>

                                <p class="card-text">Criado em:
                                    <?php echo date("d/m/Y H:m",strtotime($ordem->criado_em)); ?>
                                </p>
                                <p class="card-text">Atualizado em:
                                    <?php echo date("d/m/Y H:m",strtotime($ordem->atualizado_em));?></p>

                                <hr class="border-secondary">

                                <?php if($ordem->itens === null):?>
                                <div class="contributions py-3">

                                    <p>Nenhum item foi adicionado à esta OS</p>

                                    <?php if($ordem->situacao === 'aberta'): ?>

                                    <a class="btn btn-outline-primary btn-sm"
                                        href="<?php echo site_url("ordensitens/itens/$ordem->codigo") ?>">Adicionar
                                        itens</a>

                                </div> <!-- fim da div Contribuitions -->
                                <?php endif; ?>

                            </div> <!-- FIM Div user block text center -->
                            <?php else: ?>

                            <div class="table-responsive my-5">

                                <table class="table table-borderless table-striped table-sm">
                                    <caption>Itens adicionados a Ordem</caption>
                                    <thead>
                                        <tr>
                                            <th scope="col">Item</th>
                                            <th scope="col">Tipo</th>
                                            <th scope="col">Preço</th>
                                            <th scope="col">Qtde</th>
                                            <th scope="col">Subtotal</th>
                                            <th scope="col" class="text-center">Remover</th>
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

                                                $hiddenAcoes = [

                                                    'id_principal' => $item->id_principal,
                                                    'item_id' => $item->id,

                                                ];
                                            
                                            ?>
                                        <tr>
                                            <!-- 0 Item -->
                                            <th scope="row"><?php echo ellipsize($item->nome, 30); ?></th>

                                            <!-- 1 Tipo -->
                                            <td><?php echo esc(ucfirst($item->tipo)); ?></td>

                                            <!-- 2 Preço do item vendido -->
                                            <td>R$ <?php echo esc(number_format($item->preco_vendido, 2)); ?></td>
                                            <td>
                                                <?php echo form_open("ordensitens/atualizarquantidade/$ordem->codigo", ['class' => 'form-inline'], $hiddenAcoes); ?>
                                                <input style="max-width: 70px !important" type="number"
                                                    name="item_quantidade" class="form-control form-control-sm"
                                                    value="<?php echo $item->item_quantidade; ?>" required>
                                                <button type="submit" class="btn_table_success ml-2"><i
                                                        class="fa fa-refresh"></i></button>

                                                <?php echo form_close(); ?>
                                            </td>

                                            <td>R$ <?php echo esc(number_format($item->preco_total_vendido, 2)) ?></td>

                                            <!-- Botão de remover -->
                                            <td class="text-center">
                                                <?php 
                                    
                                                    $atributosRemover = [

                                                        'class' => 'form-inline',
                                                        'onClick' => 'return confirm("Tem certeza da exclusão?")',
                                                    ];

                                                    ?>

                                                <?php echo form_open("ordensitens/removeritem/$ordem->codigo", $atributosRemover, $hiddenAcoes); ?>

                                                <button type="submit" class="btn_table_danger ml-2 mx-auto"><i
                                                        class="fa fa-times"></i></button>

                                                <?php echo form_close(); ?>


                                            </td>
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

                                        <?php  if($ordem->valor_desconto !== null || 0): ?>
                                        <!-- Valor do desconto -->
                                        <tr>
                                            <td class="text-right font-weight-bold" colspan="4">
                                                <label class="text-white mr-3"> Valor Desconto: </label>
                                            </td>
                                            <td class="font-weight-bold">
                                                R$ <?php echo esc(number_format($ordem->valor_desconto, 2)); ?>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <tr>
                                            <td class="text-right font-weight-bold" colspan="4">
                                                <label class="text-white mr-3"> Valor Total da OS: </label>
                                            </td>
                                            <td class="font-weight-bold">
                                                R$ <?php echo esc(number_format($valorServicos + $valorProdutos, 2)); ?>
                                            </td>
                                        </tr>

                                        <!-- TR - VALOR TOTAL  -->
                                        <tr>
                                            <td class="text-right font-weight-bold" colspan="4">
                                                <label
                                                    class="text-white mr-3"><?php echo ($ordem->valor_desconto == null || 0 ? 'Valor Total: ' : 'Valor Total Com Desconto: ') ?>
                                                </label>
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

                                <div class="float-right mt-2">

                                    <div class="card">
                                        <div class="card-body">
                                            <!-- Botão para acionar modal -->
                                            <button type="button" class="btn btn-outline-info" data-toggle="modal"
                                                data-target="#modalAddDesconto">
                                                Gerenciar Desconto
                                            </button>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="card text-left">
                    <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo"
                                aria-expanded="false" aria-controls="collapseTwo">
                                Collapsible Group Item #2
                            </button>
                        </h5>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry
                            richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor
                            brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor,
                            sunt aliqua put a bird on it squid single-origin coffee nulla assumenda
                            shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson
                            cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo.
                            Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt
                            you probably haven't heard of them accusamus labore sustainable VHS.
                        </div>
                    </div>
                </div>

            </div>



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

                    <a id="btn-enviar-email" class="dropdown-item"
                        href="<?php echo site_url("ordens/email/$ordem->codigo"); ?>">Enviar por
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


<!-- Modal -->
<div class="modal fade" id="modalAddDesconto" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TituloModalCentralizado">Gerenciar Desconto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div id="response"></div>

                <div class="bock-body">


                    <?php echo form_open('/', ['id' => 'formInserir'], ['codigo' => $ordem->codigo]); ?>

                    <div class="form-row">

                        <!-- Item -->
                        <div class="form-group col-md-12">
                            <label class="form-control-label">Desconto (opcional)</label>

                            <?php $desconto = ($ordem->valor_desconto !== null ? number_format($ordem->valor_desconto, 2) : '' ); ?>

                            <input type="text" name="valor_desconto" class="form-control money"
                                value="<?php echo $desconto; ?>" placeholder="0.00">

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="mr-auto">
                    <input id="btn-inserir" class="btn btn-primary btn-sm" type="submit" value="Aplicar Desconto">
                    <button type="button" class="btn btn-secondary btn-sm ml-2" data-dismiss="modal">Cancelar</button>
                </div>
                <?php echo form_close(); ?>
            </div>

            <?php if($ordem->valor_desconto): ?>

            <?php echo form_open('/', ['id' => 'formRemover', 'class' => 'mt-2'], ['codigo' => $ordem->codigo]); ?>


            <div class="modal-footer">
                <div class="mr-auto">
                    <input id="btn-remover" class="btn btn-danger btn-lg" type="submit" value="Remover Desconto">
                </div>
                <?php echo form_close(); ?>
            </div>

            <?php endif; ?>
        </div>
    </div>
</div>


<?php $this->endSection() ?>

<!-- Scripts -->
<?php echo $this->section('scripts') ?>

<script src="<?php echo site_url("/recursos/vendor/mask/jquery.mask.min.js")?>"></script>
<script src="<?php echo site_url("/recursos/vendor/mask/app.js")?>"></script>

<script src="<?php //echo site_url('recursos/vendor/loadingoverlay/loadingoverlay.min.js'); ?>"></script>

<script>
$(document).ready(function() {

    // $("#btn-enviar-email").on('click', function() {

    //     $.LoadingOverlay("show", {
    //         image: "",
    //         fontawesome: "fa fa-spinner fa-pulse text-primary",
    //         text: "Aplicando desconto...",
    //     });

    // });

    $("#formInserir").on('submit', function(e) {

        e.preventDefault();

        $.ajax({

            type: 'POST',
            url: '<?php echo site_url('ordens/inserirdesconto'); ?>',
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {

                $("#response").html('');
                $("#btn-inserir").val('Por favor aguarde...');

            },

            success: function(response) {
                $("#btn-inserir").val('Salvar');
                $("#btn-inserir").removeAttr("disabled");

                $('[name=csrf_oberon]').val(response.token);

                if (!response.erro) {

                    if (response.info) {

                        $("#response").html('<div class="alert alert-info">' + response
                            .info + '</div>');

                    } else {

                        // Tudo certo com a atualização do usuário
                        // Podemos agora redirecioná-lo tranquilamente

                        window.location.href =
                            "<?php echo site_url("ordens/encerrar/$ordem->codigo"); ?>";

                    }

                }

                if (response.erro) {

                    // Existem erros de validação
                    $("#response").html('<div class="alert alert-danger">' + response.erro +
                        '</div>');

                    if (response.erros_model) {

                        $.each(response.erros_model, function(key, value) {

                            $("#response").append(
                                '<ul class="list-unstyled"><li class="text-danger">' +
                                value + '</li></ul>')

                        });

                    }

                }

            },

            error: function() {

                alert(
                    'Não foi possível processar a solicitação, por favor entre em contato com o suporte técnico da Oberon!'
                );
                $("#btn-inserir").val('Salvar');
                $("#btn-inserir").removeAttr("disabled");
            }

        });

    });

    $("#formRemover").on('submit', function(e) {

        e.preventDefault();

        $.ajax({

            type: 'POST',
            url: '<?php echo site_url('ordens/removerdesconto'); ?>',
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {

                $("#response").html('');
                $("#btn-remover").val('Por favor aguarde...');

            },

            success: function(response) {
                $("#btn-remover").val('Salvar');
                $("#btn-remover").removeAttr("disabled");

                $('[name=csrf_oberon]').val(response.token);

                if (!response.erro) {

                    if (response.info) {

                        $("#response").html('<div class="alert alert-info">' + response
                            .info + '</div>');

                    } else {

                        // Tudo certo com a atualização do usuário
                        // Podemos agora redirecioná-lo tranquilamente

                        window.location.href =
                            "<?php echo site_url("ordens/encerrar/$ordem->codigo"); ?>";

                    }

                }

                if (response.erro) {

                    // Existem erros de validação
                    $("#response").html('<div class="alert alert-danger">' + response.erro +
                        '</div>');

                    if (response.erros_model) {

                        $.each(response.erros_model, function(key, value) {

                            $("#response").append(
                                '<ul class="list-unstyled"><li class="text-danger">' +
                                value + '</li></ul>')

                        });

                    }

                }

            },

            error: function() {

                alert(
                    'Não foi possível processar a solicitação, por favor entre em contato com o suporte técnico da Oberon!'
                );
                $("#btn-remover").val('Salvar');
                $("#btn-remover").removeAttr("disabled");
            }

        });

    });

    $("#formInserir").submit(function() {

        $(this).find(":submit").attr('disabled', 'disabled')

    });

    $("#formRemover").submit(function() {

        $(this).find(":submit").attr('disabled', 'disabled')

    });

    $("#formEncerramento").submit(function() {

        $(this).find(":submit").attr('disabled', 'disabled')

    });



});
</script>

<?php $this->endSection() ?>