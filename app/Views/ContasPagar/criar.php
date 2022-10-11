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

    <div class="col-lg-6">

        <div class="block">

            <div class="block-body">

                <!-- Exibirá os retornos do backend -->
                <div id="response">

                </div>


                <?php echo form_open('/', ['id' => 'form'], ['id' => "$conta->id"])  ?>

                <?php echo $this->include('ContasPagar/_form'); ?>

                <div class="form-group mt-5 mb-2">

                <?php if($conta->situacao == 0): ?>
                    <input id="btn-salvar" type="submit" value="salvar" class="btn btn-primary mr-2">
                <?php endif; ?>
                    <a href="<?php echo site_url("cpagar") ?>" class="btn btn-secondary ml-2">Voltar</a>

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
<script src="<?php echo site_url('recursos/vendor/mask/jquery.mask.min.js'); ?>"></script>
<script src="<?php echo site_url('recursos/vendor/mask/app.js'); ?>"></script>



<script>
    $("#dataPagamento").hide("slow");

$(document).ready(function() {
var $select = $(".selectize").selectize({
        create: false,
        // sortField: "text",

        maxItem: 1,
        valueField: 'id',
        labelField: 'razao',
        searchField: ['razao', 'cnpj'],

        load: function(query, callback)
        {
            if(query.length < 2)
            {
                return callback();
            }

            $.ajax({

                url: '<?php echo site_url("cpagar/buscaFornecedores/") ?>?termo=' + encodeURIComponent(query),
                success: function(response)
                {
                    $select.options = response;

                    callback(response);
                },

                error: function() {
                    alert(
                        'Não foi possível processar a solicitação, por favor entre em contato com o suporte técnico da Oberon!');

                    }


            });
        }

    });

        $("#datapg").attr("readonly", true); 

        $("[name=situacao]").on("click", function() {

            if($(this).val()=="1")
            {
                $("#dataPagamento").show("slow");
                $(".pagamento").addClass('show');
                $("#datapg").attr("readonly", false); 
                
            
            }else // A conta em aberto
                {
                    $("#dataPagamento").hide("slow");       
                }

        })

                $("#form").on('submit', function(e) {

                        e.preventDefault();

                        $.ajax({

                                type: 'POST',
                                url: '<?php echo site_url('cpagar/cadastrar'); ?>',
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

                                        // Tudo certo com a atualização do usuário
                                        // Podemos agora redirecioná-lo tranquilamente
                                        window.location.href = "<?php echo site_url("cpagar/exibir/"); ?>" + response.id;

                                    }
                                        
                                    if(response.erro){

                                        // Existem erros de validação
                                        $("#response").html('<div class="alert alert-danger">'+ response.erro +'</div>');

                                        if(response.erros_model){

                                            $.each(response.erros_model, function(key, value){

                                                $("#response").append('<ul class="list-unstyled"><li class="text-danger">'+ value +'</li></ul>')

                                            });

                                        }
                                    
                                    }

                                    },

                                    error: function() {

                                        alert(
                                            'Não foi possível processar a solicitação, por favor entre em contato com o suporte técnico da Oberon!');
                                            $("#btn-salvar").val('Salvar');
                                            $("#btn-salvar").removeAttr("disabled");
                                    }

                                });

                        });

                    $("#form").submit(function(){

                        $(this).find(":submit").attr('disabled', 'disabled')

                    });     
                    

                
                });
</script>

<?php $this->endSection() ?>