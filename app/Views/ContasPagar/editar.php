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


                <?php echo form_open('/', ['id' => 'form'], ['id' => "$conta->id"])  ?>

                <?php echo $this->include('ContasPagar/_form'); ?>

                <div class="form-group mt-5 mb-2">

                    <input id="btn-salvar" type="submit" value="salvar" class="btn btn-primary mr-2">

                    <a href="<?php echo site_url("cpagar/exibir/$conta->id") ?>" class="btn btn-secondary ml-2">Voltar</a>

                </div>

                <?php echo form_close(); ?>

            </div>


        </div> <!-- FIM DO DIV BLOCK -->



    </div>

</div>


<?php $this->endSection() ?>

<!-- Scripts -->
<?php echo $this->section('scripts') ?>

<?php if($conta->situacao == false): ?>


<script>
$(document).ready(function() 
{
    $("[name=situacao]").on("click", function() {

        if($(this).val()=="1")
        {
            $("#dataPagamento").show("slow");
            $(".pagamento").addClass('show');
            
        
        }else // A conta em aberto
            {
                $("#dataPagamento").hide("slow");       
            }

    })

            $("#form").on('submit', function(e) {

                    e.preventDefault();

                    $.ajax({

                            type: 'POST',
                            url: '<?php echo site_url('cpagar/atualizar'); ?>',
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

                                        $("#response").html('<div class="alert alert-info">'+ response.info +'</div>');

                                        } else {

                                            // Tudo certo com a atualização do usuário
                                            // Podemos agora redirecioná-lo tranquilamente

                                            window.location.href = "<?php echo site_url("cpagar/exibir/$conta->id"); ?>";

                                    }

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