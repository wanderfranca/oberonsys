$('[name=email]').on('change', function() {

var email = $(this).val();

if (email != '') {
    
    $.ajax({

        type: 'GET',
        url: '<?php echo site_url('clientes/consultaemail'); ?>',
        data: {
            email: email
        },
        dataType: 'json',
        beforeSend: function() {

            // ---- OVERLAY --- //
            $("#form").LoadingOverlay("show", {
                image: "",
                fontawesome: "fa fa-spinner fa-pulse text-primary"

            });

            $("#email").html('');

        },

        success: function(response) {

            // ---- DESABILITAR OVERLAY --- //
            $("#form").LoadingOverlay("hide", true), ({
                image: "",
                fontawesome: "fa fa-spinner fa-pulse text-primary"

            });

            if (!response.erro) {

                $("#email").html('');

            }

            if (response.erro) {

                // Existem erros de validação
                $("#email").html(response.erro);

            }

        },

        error: function() {

                // ---- DESABILITAR OVERLAY --- //
                $("#form").LoadingOverlay("hide", true), ({
                image: "",
                fontawesome: "fa fa-spinner fa-pulse text-primary"

            });

            alert(
                'Não foi possível processar a solicitação, por favor entre em contato com o suporte técnico da Oberon!'
            );

        }

    });


}

});