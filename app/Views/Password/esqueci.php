<!DOCTYPE html>

<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Oberon - <?php echo $titulo; ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
        </script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
        </script>
    </head>

    <style>
    .login,
    .image {
        min-height: 100vh;
    }

    .bg-image {
        background-image: url('<?php echo site_url('imgs/')?>sistema/obn_esqueceu.png');
        background-size: cover;
        background-position: center center;
    }
    </style>

    <body>
        <div class="container-fluid">
            <div class="row no-gutter">
                <!-- The image half -->
                <div class="col-md-6 d-none d-md-flex bg-image"></div>
                <!-- The content half -->
                <div class="col-md-6 bg-light">
                    <div class="login d-flex align-items-center py-5">
                        <!-- Demo content-->
                        <div class="container">
                            <div class="row">

                                <div class="col-lg-10 col-xl-7 mx-auto">
                                    <div class="text-center pb-2">
                                        <img src="<?php echo site_url('imgs/')?>sistema/Ologo.png">
                                        <h5 class="mb-5 text-primary ml-4 pl-2 font-weight-bolder"> Gestão </h5>
                                    </div>
                                    <div class="text-center">
                                        <h4 class="text-lg-center mb-4">Recupere sua senha</h4>
                                    </div>
                                    <div class="text-center">
                                        <h6 class="text-center mb-4">Informe seu e-mail abaixo:</h6>
                                    </div>
                                    <div id="response">
                                    </div>
                                    <?php echo $this->include('Layout/_mensagens'); ?>

                                    <?php echo form_open('/', ['id' => 'form', 'class'=>'user']) ?>
                                    <div class="form-group mb-3">

                                        <input id="login-username" name="email" type="text"
                                            placeholder="Informe seu e-mail" required
                                            data-msg="Por favor, informe seu e-mail" autofocus=""
                                            class="offz form-control  border-0 shadow-sm px-4 text-black" require
                                            disabled>
                                    </div>

                                    <input id="btn-esqueci" type="submit"
                                        class="btn btn-primary btn-block text-uppercase mb-2 shadow-sm" value="ENVIAR">
                                    <?php echo form_close(); ?>
                                    <div class="text-center d-flex justify-content-between mt-4">
                                    <p>Lembrou sua senha? <a href="<?php echo site_url('login') ?>" class="font-italic ">
                                                <u>Ir para Login</u></a>
                                    </div>

                                </div>

                            </div>

                        </div><!-- End -->

                    </div>
                </div><!-- End -->

            </div>
        </div>
    </body>

    <script src="<?php echo site_url('recursos/');?>vendor/jquery/jquery.min.js"></script>

    <script>
    $(document).ready(function() {

        $("#form").on('submit', function(e) {

            e.preventDefault();

            $.ajax({

                type: 'POST',
                url: '<?php echo site_url('password/processaesqueci'); ?>',
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {

                    $("#response").html('');
                    $("#btn-esqueci").val('Por favor aguarde...');

                },

                success: function(response) {
                    $("#btn-esqueci").val('ENVIAR');
                    $("#btn-esqueci").removeAttr("disabled");

                    $('[name=csrf_oberon]').val(response.token);

                    if (!response.erro) {

                        window.location.href = "<?php echo site_url("password/resetenviado"); ?>";

                    }

                    if (response.erro) {

                        // Existem erros de validação
                        $("#response").html('<div class="alert alert-danger">' + response.erro + '</div>');

                        if (response.erros_model) {

                            $.each(response.erros_model, function(key, value) {

                                $("#response").append(
                                    '<ul class="list-unstyled"><li class="text-danger">' + value + '</li></ul>')

                            });

                        }

                    }

                },

                error: function() {

                    alert(
                        'Não foi possível processar a solicitação, por favor entre em contato com o suporte técnico da Oberon!'
                    );
                    $("#btn-esqueci").val('ENVIAR');
                    $("#btn-esqueci").removeAttr("disabled");
                }

            });

        });

        $("#form").submit(function() {

            $(this).find(":submit").attr('disabled', 'disabled')

        });



    });
    </script>


    <script>
    function getRidOffAutocomplete() {
        var timer = window.setTimeout(function() {
                $('.offz').prop('disabled', false);
                clearTimeout(timer);
            },
            900);
    }

    // Invoke the function, handle page load autocomplete by chrome.
    getRidOffAutocomplete();
    </script>

    <script src="<?php echo site_url('recursos/');?>js/close-alert.js"></script>

</html>