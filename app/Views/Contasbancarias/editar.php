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

                <!-- Exibirá os retornos do backend -->
                <div id="response">

                </div>

                <?php echo form_open('/', ['id' => 'form'], ['id' => "$contabancaria->id"])  ?>

                <?php echo $this->include('contasbancarias/_form'); ?>

                <div class="form-group mt-5 mb-2">

                    <input id="btn-salvar" type="submit" value="salvar" class="btn btn-primary mr-2">

                    <a href="<?php echo site_url("contasbancarias") ?>" class="btn btn-secondary mr-2">Voltar</a>

                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#excluirCC">Excluir esta conta</button>

                </div>

                <?php echo form_close(); ?>

            </div>

        </div> <!-- FIM DO DIV BLOCK -->

    </div>

</div>

<?php echo form_open("contasbancarias/excluir/$contabancaria->id")  ?>
<!-- Modal -->
<div class="modal fade" id="excluirCC" tabindex="-1" role="dialog" aria-labelledby="excluirCCLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="excluirCCLabel">Excluir conta bancária</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <p class="text-white"> Você realmente deseja excluir esta conta bancária do sistema?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <input id="btn-salvar" type="submit" value="Sim, desejo excluir" class="btn btn-danger btn-sm mr-1">
      </div>
    </div>
  </div>
</div>
<?php echo form_close(); ?>


<?php $this->endSection() ?>

<!-- Scripts -->
<?php echo $this->section('scripts') ?>
<script src="<?php echo site_url('recursos/vendor/mask/app.js'); ?>"></script>
<script src="<?php echo site_url('recursos/vendor/mask/jquery.mask.min.js'); ?>"></script>

<script>
$(document).ready(function() {

            $("#form").on('submit', function(e) {

                    e.preventDefault();

                    $.ajax({

                            type: 'POST',
                            url: '<?php echo site_url('contasbancarias/atualizar'); ?>',
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

                                            window.location.href = "<?php echo site_url("contasbancarias"); ?>";

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