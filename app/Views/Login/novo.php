<?php

//SAUDAÇÃO EM TEXTO
function saudacao() {
	date_default_timezone_set('America/Sao_Paulo');
	$hora = date('H');
	if( $hora >= 6 && $hora <= 12 )
		return 'Bom dia' . (empty($nome) ? '' : ', ');
	else if ( $hora > 12 && $hora <=18  )
		return 'Boa tarde' . (empty($nome) ? '' : ', ');
	else
		return 'Boa noite' . (empty($nome) ? '' : ', ');
}

?>


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
        background-image: url('<?php echo site_url('imgs/')?>bg.jpg');
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

                                <?php echo $this->include('Layout/_mensagens'); ?>

                                <div class="col-lg-10 col-xl-7 mx-auto">

                                    <div class="text-center pb-2">
                                        <img src="<?php echo site_url('imgs/')?>Ologo.png">
                                        <h5 class="mb-5 text-primary ml-2 pl-2 font-weight-bolder"> Gestão </h5>
                                    </div>
                                    <div class="text-center">


                                        <h5 class="text-lg-center mb-4"><?php echo saudacao(); ?>, seja bem-vindo!</h5>
                                    </div>

                                    <form class="user" name="form_auth" method="POST"
                                        action="<?php echo base_url('login/auth'); ?>">

                                        <div class="form-group mb-3">
                                            <input id="inputEmail" name="email" type="text" placeholder="E-mail" required
                                                autofocus="" class="form-control  border-0 shadow-sm px-4"
                                                value="<?php echo set_value('email'); ?>">
                                        </div>
                                        <div class="form-group mb-3">
                                            <input id="inputPassword" name="password" type="password"
                                                placeholder="Senha" required data-validate="Password is required"
                                                class="form-control border-0 shadow-sm px-4 text-primary">
                                        </div>
                                        <button type="submit"
                                            class="btn btn-primary btn-block text-uppercase mb-2  shadow-sm">ENTRAR</button>
                                        <div class="text-center d-flex justify-content-between mt-4">
                                            <p>Esqueceu sua senha? <a href="#" class="font-italic ">
                                                    <u>Clique Aqui</u></a></p>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div><!-- End -->

                    </div>
                </div><!-- End -->

            </div>

        </div>

    </body>

</html>