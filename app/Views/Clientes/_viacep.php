$('[name=cep]').on('keyup', function() {

let cep = $(this).val();

if (cep.length === 9) {
    
    $.ajax({

        type: 'GET',
        url: '<?php echo site_url('clientes/consultacep'); ?>',
        data: {
            cep: cep
        },
        dataType: 'json',
        beforeSend: function() {

            // ---- OVERLAY --- //
            $("#form").LoadingOverlay("show", {
                image: "",
                fontawesome: "fa fa-spinner fa-pulse text-primary"

            });

            $("#cep").html('');

        },

        success: function(response) {

            // ---- DESABILITAR OVERLAY --- //
            $("#form").LoadingOverlay("hide", true), ({
                image: "",
                fontawesome: "fa fa-spinner fa-pulse text-primary"

            });

            if (!response.erro) {

                if(!response.endereco)
                {
                    $('[name=endereco]').prop('readonly', false);
                    $('[name=endereco]').focus();
                }

                if(!response.bairro)
                {
                    $('[name=bairro]').prop('readonly', false);
                    $('[name=bairro]').focus();
                }

                // Preencher os inputs de endereço
                $('[name=endereco]').val(response.endereco);
                $('[name=bairro]').val(response.bairro);
                $('[name=cidade]').val(response.cidade);
                $('[name=estado]').val(response.estado);
                $('[name=numero]').focus();
                

            }

            if (response.erro) {

                // Existem erros de validação
                $("#cep").html(response.erro);

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