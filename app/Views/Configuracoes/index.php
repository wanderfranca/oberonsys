<?php echo $this->extend('Layout/principal') ?>

<?php echo $this->section('titulo') ?> <?php echo $titulo; ?><?php $this->endSection() ?>

<!-- Estilos -->
<?php echo $this->section('estilos') ?>
<?php $this->endSection() ?>

<!-- Conteúdo -->
<?php echo $this->section('conteudo') ?>
<div class="row">
    <div class="col-lg-10">
        <div class="block">
            <div class="block-body">

                <!-- Exibirá os retornos do backend -->
                <div id="response">

                </div>

                <?php echo form_open('/', ['id' => 'form'], ['id' => "$configs->id"])  ?>
                <ul class="nav nav-pills mb-5" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pill-empresa-tab" data-toggle="pill" href="#pill-empresa"
                            role="tab" aria-controls="pill-empresa" aria-selected="true">Dados da empresa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
                            aria-controls="pills-profile" aria-selected="false">Configuração de E-mail</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab"
                            aria-controls="pills-contact" aria-selected="false">Apis</a>
                    </li>
                </ul>

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pill-empresa" role="tabpanel"
                        aria-labelledby="pill-empresa-tab">
                        <!-- FORM EMPRESA -->
                        <?php echo $this->include('Configuracoes/_form_empresa'); ?>
                    </div>

                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        ...
                    </div>
                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                        ...</div>
                </div>

                <div class="form-group mt-5 mb-2">

                    <input id="btn-salvar" type="submit" value="salvar" class="btn btn-primary mr-2">

                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>

</div>



<?php $this->endSection() ?>

<!-- Scripts -->
<?php echo $this->section('scripts') ?>

<script>
$(document).ready(function() {

    $("#form").on('submit', function(e) {

        e.preventDefault();

        $.ajax({

            type: 'POST',
            url: '<?php echo site_url('configuracoes/atualizar'); ?>',
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

                    if (response.info) {

                        $("#response").html('<div class="alert alert-info">' + response
                            .info + '</div>');

                    } else {

                        // Tudo certo com a atualização do usuário
                        // Podemos agora redirecioná-lo tranquilamente

                        window.location.href =
                            "<?php echo site_url("configuracoes/exibir/$configs->id"); ?>";

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