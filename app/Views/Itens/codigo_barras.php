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
@media print{
    body *:not(#nocodebar):not(#nocodebar *){
        visibility: hidden;
    }

    .nocodebar:not(nocodebar):not(nocodebar *){
        visibility: hidden;
    }

    #nocodebar{
        position: absolute;
        bottom: 40%;
        left: 0%;
        right: 100%;
    }
}
        
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
    <section id="nocodebar">
        <div class="container-fluid">
            <div class="row no-gutter">
                <!-- The image half -->
                <div class="col-md-6 d-none d-md-flex bg-image"></div>
                </<section>
                    
                <!-- The content half -->
                <div class="col-md-6 bg-light">
                    <div class="login d-flex align-items-center py-5 bg-info">
                        <!-- Demo content-->
                        <div class="container">
                        
                            <div class="row">
                                <div class="col-lg-8 col-xl-7 mx-auto">
                                    <div class="text-center pb-2">
                                        <p class=""><?php echo $item->nome;?></p>
                                        <p><?php echo $item->codigo_barras;?></p>
                                        <p><?php echo $item->codigo_interno; ?></p>
                                        <button id="btn-print" onclick="window.print();" class="btn btn-primary shadow-sm mt-4 nocodebar">Imprimir</button>
                                    </div>           

                            </div>

                        </div><!-- End -->
                    </div>
                </div><!-- End -->
  </div>
        </div>
    </body>

    

    <script>

        function printDiv(imprimir) {
        //pega o Html da DIV
        var divElements = document.getElementById(imprimir).innerHTML;
        //pega o HTML de toda tag Body
        var oldPage = document.body.innerHTML;

        //Alterna o body 
        document.body.innerHTML = 
          "<html><head><title></title></head><body>" + 
          divElements + "</body>";

        //Imprime o body atual
        window.print();

        //Retorna o conteudo original da página. 
        document.body.innerHTML = oldPage;

    }

    </script>

</html>