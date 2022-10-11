<?php echo $this->extend('Layout/principal') ?>

<?php echo $this->section('titulo') ?> <?php echo $titulo; ?><?php $this->endSection() ?>

<!-- Estilos -->
<?php echo $this->section('estilos') ?>
<?php $this->endSection() ?>

<!-- Conteúdo -->
<?php echo $this->section('conteudo') ?>

<div class="row">

    <div class="col-lg-8">

        <div class="block">

            <div class="block-body">

                <!-- Exibirá os retornos do backend -->
                <div id="response">

                </div>

                <?php echo form_open_multipart('/', ['id' => 'form'], ['id' => "$fornecedor->id"])  ?>

                <?php echo $this->include('Fornecedores/_form_nf'); ?>

                <div class="form-group mt-5 mb-2">

                    <input id="btn-salvar" type="submit" value="salvar" class="btn btn-primary mr-2">

                    <a href="<?php echo site_url("fornecedores/exibir/$fornecedor->id") ?>"
                        class="btn btn-secondary ml-2">Voltar</a>

                </div>

                <?php echo form_close(); ?>

            </div>

        </div>

    </div> <!-- FIM DO DIV BLOCK -->

    <div class="col-lg-12">

        <div class="user-block block">

            <?php if(empty($fornecedor->notas_fiscais)): ?>

            <p class="text-warning mt-0 row d-flex justify-content-center">Nenhuma nota fiscal foi atribuída a este fornecedor</p>

            <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-sm table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Data de Emissão</th>
                            <th>Valor da NF</th>
                            <th>Observação</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($fornecedor->notas_fiscais as $nota_fiscal): ?>
                        <tr>
                            <td><?php echo date('d/m/Y',strtotime($nota_fiscal->data_emissao)); ?></td>
                            <td>R$ <?php echo  number_format($nota_fiscal->valor_nota, 2); ?></td>
                            <td ><?php echo ellipsize($nota_fiscal->descricao_itens, 20, .5); ?></td>

                            
                            <td class="text-center">

                                <?php $atributos = [
                                    'onSubmit' => "return confirm('Deseja excluir esta nota fiscal?');",
                                ]; ?>

                                <?php echo form_open("fornecedores/removenota/$nota_fiscal->nota_fiscal", $atributos)  ?>

                                <a target="_blank" href="<?php echo site_url("fornecedores/exibirnota/$nota_fiscal->nota_fiscal") ?>" title="Ver nota" class="btn btn-sm  btn-primary"><i class="fa fa-file-pdf-o"></i></a>

                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>


                                <?php echo form_close(); ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="mt-3 ml-1">
                    <?php echo $fornecedor->pager->links(); ?>
                </div>

            </div> <!-- FIM DO DIV BLOCK -->
            <?php endif; ?>
        </div>
    </div>




    <?php $this->endSection() ?>

    <!-- Scripts -->
    <?php echo $this->section('scripts') ?>

    <script src="<?php echo site_url('recursos/vendor/loadingoverlay/loadingoverlay.min.js'); ?>"></script>
    <script src="<?php echo site_url('recursos/vendor/mask/jquery.mask.min.js'); ?>"></script>
    <script src="<?php echo site_url('recursos/vendor/mask/app.js'); ?>"></script>

    <script>
    $(document).ready(function() {

        $("#form").on('submit', function(e) {

            e.preventDefault();

            $.ajax({

                type: 'POST',
                url: '<?php echo site_url('fornecedores/cadastrarnotafiscal'); ?>',
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {

                    $("#response").html('');
                    $("#btn-salvar").val('Por favor aguarde...');

                },

                success: function(response) {
                    $("#btn-salvar").val('Salvar');
                    $("#btn-salvar").removeAttr("disabled");

                    $('[name=csrf_oberon]').val(response.token);

                    if (!response.erro) {

                        window.location.href = "<?php echo site_url("fornecedores/notas/$fornecedor->id"); ?>";

                    }

                    if (response.erro) {

                        // Existem erros de validação
                        $("#response").html('<div class="alert alert-danger">' + response.erro +'</div>');

                        if (response.erros_model) {

                            $.each(response.erros_model, function(key, value) {

                                $("#response").append('<ul class="list-unstyled"><li class="text-danger">' + value + '</li></ul>')

                            });

                        }

                    }

                },

                error: function() {

                    alert(
                        'Não foi possível processar a solicitação, por favor entre em contato com o suporte técnico da Oberon!'
                    );
                    $("#btn-salvar").val('Salvar');
                    $("#btn-salvar").removeAttr("disabled");
                }

            });

        });

        $("#form").submit(function() {

            $(this).find(":submit").attr('disabled', 'disabled')

        });



    });
    </script>

    <?php $this->endSection() ?>