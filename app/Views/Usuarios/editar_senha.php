<?php echo $this->extend('Layout/principal') ?>

<?php echo $this->section('titulo') ?> <?php echo $titulo; ?><?php $this->endSection() ?>

<!-- Estilos -->
<?php echo $this->section('estilos') ?>
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


                <?php echo form_open('/', ['id' => 'form'])  ?>

                <div class="form-group">
                    <label class="form-control-label">Senha atual</label>
                    <input type="password" name="current_password" class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-control-label">Nova senha</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-control-label">Repita a nova senha</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

                <div class="form-group mt-5 mb-2">
                    <input id="btn-salvar" type="submit" value="salvar" class="btn btn-primary btn-sm mr-1">
                    <a href="<?php echo site_url("/") ?>" class="btn btn-secondary btn-sm ml-1">Voltar</a>

                </div>

                <?php echo form_close(); ?>

            </div>


        </div> <!-- FIM DO DIV BLOCK -->



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
                            url: '<?php echo site_url('usuarios/atualizarsenha'); ?>',
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

                                    // Limpar o form
                                    $("#form")[0].reset();

                                    if(response.info)
                                    {
                                        $("#response").html('<div class="alert alert-info">'+ response.info +'</div>');

                                    }else {
                                        
                                        $("#response").html('<div class="alert alert-success">'+ response.sucesso +'</div>');

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