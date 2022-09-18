<?php echo $this->extend('Layout/principal') ?>

<?php echo $this->section('titulo') ?> <?php echo $titulo; ?><?php $this->endSection() ?>

<!-- Estilos -->
<?php echo $this->section('estilos') ?>

<link rel="stylesheet" type="text/css"
    href="<?php echo site_url('recursos/vendor/selectize/selectize.bootstrap4.css'); ?>" />

<style>
/* Estilizando o select para acompanhar a formatação do template */

.selectize-input,
.selectize-control.single .selectize-input.input-active {
    background: #2d3035 !important;
}

.selectize-dropdown,
.selectize-input,
.selectize-input input {
    color: #fbfbfb;
    background-color: #303030;
}

.selectize-input {
    /*        height: calc(2.4rem + 2px);*/
    border: 1px solid #444951;
    border-radius: 0;
}
</style>

<?php $this->endSection() ?>

<!-- Conteúdo -->
<?php echo $this->section('conteudo') ?>

<div class="row">

    <div class="col-lg-8">

        <div class="block">


            <div class="user-block text-center">

                <div class="user-title mb-4">
                    <h5 class="card-title mt-2"><?php echo esc($ordem->nome);?></h5>
                    <span>Tag: <?php echo esc($ordem->codigo); ?></span>
                </div>

                <p class="contributions mt-0"><?php echo $ordem->exibeSituacao(); ?></p>
                <p class="contributions mt-0">Aberta por: <?php echo esc($ordem->usuario_abertura); ?></p>

                <p class="contributions mt-0">Técnico:
                    <?php echo esc($ordem->usuario_responsavel !== null ? $ordem->usuario_responsavel : 'Não definido'); ?>
                </p>

                <?php if($ordem->situacao === 'encerrada'): ?>
                <p class="contributions mt-0">Encerrada por: <?php echo esc($ordem->usuario_encerramento); ?>
                </p>
                <?php endif; ?>

                <p class="card-text">Criado em: <?php echo date("d/m/Y H:m",strtotime($ordem->criado_em)); ?>
                </p>
                <!-- <p class="card-text">Atualizado em: <?php echo date("d/m/Y H:m",strtotime($ordem->atualizado_em));?></p> -->

                <hr class="border-secondary">
                <!-- Exibirá os retornos do backend -->
                <div id="response">

                </div>


                <?php echo form_open('/', ['id' => 'form', 'class'=> 'text-left'], ['codigo' => "$ordem->codigo"])  ?>

                <!-- cliente  -->
                <div class="form-group">
                    <label class="form-control-label">Escolha o técnico <b class="text-primary">*</b></label>
                    <select name="usuario_responsavel_id" class="selectize" required>
                        <option value="">Digite o nome do técnico</option>
                    </select>
                </div>

                <div class="form-group mt-5 mb-2">

                    <?php if($ordem->situacao == 0): ?>
                    <input id="btn-salvar" type="submit" value="salvar" class="btn btn-primary mr-2">
                    <?php endif; ?>
                    <a href="<?php echo site_url("ordens/detalhes/$ordem->codigo") ?>"
                        class="btn btn-secondary ml-2">Voltar</a>

                </div>

                <?php echo form_close(); ?>

            </div>

        </div> <!-- FIM DO DIV BLOCK -->

    </div>
</div>


<?php $this->endSection() ?>

<!-- Scripts -->
<?php echo $this->section('scripts') ?>
<script type="text/javascript" src="<?php echo site_url('recursos/vendor/selectize/selectize.min.js'); ?>"></script>

<script>
$(document).ready(function() {

    var $select = $(".selectize").selectize({
        create: false,
        // sortField: "text",

        maxItem: 1,
        valueField: 'id',
        labelField: 'nome',
        searchField: ['nome'],

        load: function(query, callback) {
            if (query.length < 2) {
                return callback();
            }

            $.ajax({

                url: '<?php echo site_url("ordens/buscaResponsaveis/") ?>',
                data: {
                    termo: encodeURIComponent(query)
                },

                success: function(response) {
                    $select.options = response;

                    callback(response);
                },

                error: function() {
                    alert(
                        'Não foi possível processar a solicitação, por favor entre em contato com o suporte técnico da Oberon!'
                    );

                }


            });
        }

    }); // Fim Selectize


    $("#form").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('ordens/definirResponsavel'); ?>',
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

                    window.location.href = "<?php echo site_url("ordens/responsavel/$ordem->codigo"); ?>";
                }

                if (response.erro) {

                    // Existem erros de validação
                    $("#response").html('<div class="alert alert-danger">' + response.erro + '</div>');

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