<?php echo $this->extend('Layout/principal') ?>

<?php echo $this->section('titulo') ?> <?php echo $titulo; ?><?php $this->endSection() ?>

<!-- Estilos -->
<?php echo $this->section('estilos') ?>
<?php $this->endSection() ?>

<!-- Conteúdo -->
<?php echo $this->section('conteudo') ?>

<div class="row">

    <div class="col-lg-5">

        <div class="block">

            <div class="block-body">

                <?php if(count($item->imagens) >=10 ): ?>

                <p class="contributions d-flex align-items-center justify-content-center text-white">Esse produto já possui o máximo de
                    <?php echo count($item->imagens); ?> imagens permitidas.<br>
                    Você pode remover imagens existentes e inserir novas imagens.
                </p>

                <?php else: ?>

                <!-- Exibirá os retornos do backend -->
                <div id="response">

                </div>

                <?php echo form_open_multipart('/', ['id' => 'form'], ['id' => "$item->id"])  ?>

                <?php echo $this->include('itens/_form_img'); ?>

                <div class="form-group mt-5 mb-2">

                    <input id="btn-salvar" type="submit" value="salvar" class="btn btn-primary mr-2">

                    <a href="<?php echo site_url("itens/exibir/$item->id") ?>" class="btn btn-secondary ml-2">Voltar</a>

                </div>

                <?php echo form_close(); ?>

                <?php endif; ?>



            </div>

        </div>

    </div> <!-- FIM DO DIV BLOCK -->

    <div class="col-lg-7">

        <div class="user-block block">

            <?php if(empty($item->imagens)): ?>

            <p class="text-warning mt-0 row d-flex justify-content-center">Esse produto ainda não possui nenhuma imagem
            </p>

            <?php else: ?>

            <ul class="list-inline">

                <?php foreach($item->imagens as $imagem): ?>

                <li class="list-inline-item">
                    <div class="card" style="width: 10rem;">

                        <img class="card-img-top" src="<?php echo site_url("itens/imagem/$imagem->imagem")?>"
                            alt="<?php echo esc($item->nome); ?>">
                        <div class="card-body text-center">

                            <?php $atributos = [
                                'onSubmit' => "return confirm('Deseja excluir essa imagem?');",
                            ]; 
                            
                            ?>

                            <?php echo form_open("itens/removeimagem/$imagem->imagem", $atributos)  ?>

                            <button type="submit" class="btn btn-sm btn-danger">Excluir</button>

                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </li>

                <?php endforeach; ?>

            </ul>

            <?php endif; ?>
        </div>
    </div>




    <?php $this->endSection() ?>

    <!-- Scripts -->
    <?php echo $this->section('scripts') ?>

    <script src="<?php echo site_url('recursos/vendor/mask/jquery.mask.min.js'); ?>"></script>
    <script src="<?php echo site_url('recursos/vendor/mask/app.js'); ?>"></script>

    <script>
    $(document).ready(function() {

        $("#form").on('submit', function(e) {

            e.preventDefault();

            $.ajax({

                type: 'POST',
                url: '<?php echo site_url('itens/upload'); ?>',
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

                        window.location.href =
                            "<?php echo site_url("itens/editarimagem/$item->id"); ?>";

                    }

                    if (response.erro) {

                        // Existem erros de validação
                        $("#response").html('<div class="alert alert-danger">' + response
                            .erro + '</div>');

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