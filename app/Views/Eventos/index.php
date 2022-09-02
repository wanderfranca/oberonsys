<?php echo $this->extend('Layout/principal') ?>

<?php echo $this->section('titulo') ?> <?php echo $titulo; ?><?php $this->endSection() ?>

<!-- Estilos -->
<?php echo $this->section('estilos') ?> 

<link rel="stylesheet" href="<?php echo site_url('recursos/vendor/fullcalendar/fullcalendar.min.css');?>">
<link rel="stylesheet" href="<?php echo site_url('recursos/vendor/fullcalendar/toastr.min.css');?>">
 <style>

/* .fc-event, .fc-event-dot {
    
} */

a:not([href]):not([tabindex]){
    color: azure;
}

</style>


<?php $this->endSection() ?>

<!-- Conteúdo -->
<?php echo $this->section('conteudo') ?> 


<div id="calendario" class="container-fluid">
<!-- Calendario -->



</div> <!--fim do calendario -->




<?php $this->endSection() ?>

<!-- Scripts -->
<?php echo $this->section('scripts') ?>

<script src="<?php echo site_url('recursos/vendor/fullcalendar/fullcalendar.min.js');?>"></script>
<script src="<?php echo site_url('recursos/vendor/fullcalendar/toastr.min.js');?>"></script>
<script src="<?php echo site_url('recursos/vendor/fullcalendar/moment.min.js');?>"></script>

<script>
    $(document).ready(function(){

        var calendario = $("#calendario").fullCalendar({

            header: {

                left: 'prev, next, today',
                center: 'title',
                right: 'month',

            },

            height: 580,
            editable: true,
            events: '<?php echo site_url('eventos/eventos') ?>',
            displayEventTime: false,
            selectable: true,
            selectHelper: true,
            select: function(start, end, allDay){

                var title = prompt('Informe o título do evento');

                if(title)
                {
                    var start = $.fullCalendar.formatDate(start, 'Y-MM-DD'); // Formatação do moment.js
                    var end = $.fullCalendar.formatDate(end, 'Y-MM-DD'); // Formatação do moment.js

                    $.ajax({

                        url: '<?php echo site_url('eventos/cadastrar'); ?>',
                        type: 'GET',
                        data:{
                            title:title,
                            start:start,
                            end:end,
                        },

                        success: function(response)
                        {
                            exibeMensagem('Evento criado com sucesso!');

                            calendario.fullCalendar('renderEvent', {
                                id:response.id,
                                title:title,
                                start:start,
                                end:end,
                                allDay:allDay,
                            }, true);
                            calendario.fullCalendar('unselect');
                        }, // Fim success

                    }); // fim Ajax Cadastro
                    
                } // fim if title
            },


            //Atualiza evento
            eventDrop: function(event, delta, revertFunc)
            {
                if(event.contapagar_id || event.ordem_id)
                {
                    alert('Não é possível alterar um evento Financeiro ou O.S');
                    revertFunc();
                }else {
                    //Evento editável
                    var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD'); // Formatação do moment.js
                    var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD'); // Formatação do moment.js

                    $.ajax({
                        url: '<?php echo site_url('eventos/atualizar/'); ?>'+ event.id, //Id do evento a ser atualizado
                        type: 'GET',
                        data:{
                            start:start,
                            end:end,
                        },
                        success: function(response)
                        {
                            exibeMensagem('Evento atualizado com sucesso!');

                        }, // Fim success

                    }); // fim Ajax Atualização
                } // fim else
            },
        });
    });

    // Função para exibir msg
    function exibeMensagem(mensagem)
    {
        toastr.success(mensagem, 'Evento');
    }

</script>


<?php $this->endSection() ?>