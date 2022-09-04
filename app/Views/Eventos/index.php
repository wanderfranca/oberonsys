<?php echo $this->extend('Layout/principal') ?>

<?php echo $this->section('titulo') ?> <?php echo $titulo; ?><?php $this->endSection() ?>

<!-- Estilos -->
<?php echo $this->section('estilos') ?>

<link rel="stylesheet" href="<?php echo site_url('recursos/vendor/fullcalendar/fullcalendar.min.css');?>">
<link rel="stylesheet" href="<?php echo site_url('recursos/vendor/fullcalendar/toastr.min.css');?>">
<style>
.fc-unthemed .fc-divider,
.fc-unthemed .fc-list-heading td,
.fc-unthemed .fc-popover .fc-header {
    background-color: #191b50;
}

a:not([href]):not([tabindex]) {
    color: azure;
}
</style>


<?php $this->endSection() ?>

<!-- Conteúdo -->
<?php echo $this->section('conteudo') ?>


<div id="calendario" class="container-fluid">
    <!-- Calendario -->



</div>
<!--fim do calendario -->




<?php $this->endSection() ?>

<!-- Scripts -->
<?php echo $this->section('scripts') ?>

<script src="<?php echo site_url('recursos/vendor/fullcalendar/fullcalendar.min.js');?>"></script>
<script src="<?php echo site_url('recursos/vendor/fullcalendar/locale/pt-br.js');?>"></script>
<script src="<?php echo site_url('recursos/vendor/fullcalendar/toastr.min.js');?>"></script>
<script src="<?php echo site_url('recursos/vendor/fullcalendar/moment.min.js');?>"></script>

<script>
$(document).ready(function() {

    var calendario = $("#calendario").fullCalendar({
        locale: 'pt-br',
        lang: 'pt-br',
        header: {
            left: 'prev, next, today',
            center: 'title',
            right: 'month, list',

        },

        buttonText: {
            today: 'Hoje',
            month: 'Mês',
            week: 'Semana',
            day: 'Hoje',
            list: 'Lista'
        },

        monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto',
            'Setembro', 'Outubro', 'Novembro', 'Dezembro'
        ],
        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov',
            'Dez'
        ],
        dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sabado'],
        dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],

        height: 600,
        editable: true,
        navLinks: true,
        events: '<?php echo site_url('eventos/eventos') ?>',
        displayEventTime: false,
        selectable: true,
        selectHelper: true,
        select: function(start, end, allDay) {

            var title = prompt('Informe o título do evento');

            if (title) {
                var start = $.fullCalendar.formatDate(start, 'Y-MM-DD'); // Formatação do moment.js
                var end = $.fullCalendar.formatDate(end, 'Y-MM-DD'); // Formatação do moment.js

                $.ajax({

                    url: '<?php echo site_url('eventos/cadastrar'); ?>',
                    type: 'GET',
                    data: {
                        title: title,
                        start: start,
                        end: end,
                    },

                    success: function(response) {
                        exibeMensagem('Evento criado com sucesso!');

                        calendario.fullCalendar('renderEvent', {
                            id: response.id,
                            title: title,
                            start: start,
                            end: end,
                            allDay: allDay,
                        }, true);
                        calendario.fullCalendar('unselect');
                    }, // Fim success

                }); // fim Ajax Cadastro

            } // fim if title
        },

        //ATUALIZAR EVENTO ----
        eventDrop: function(event, delta, revertFunc) {
            if (event.contapagar_id || event.ordem_id) {
                alert('Não é possível alterar um evento Financeiro ou O.S');
                revertFunc();
            } else {
                //Evento editável
                var start = $.fullCalendar.formatDate(event.start,
                'Y-MM-DD'); // Formatação do moment.js
                var end = $.fullCalendar.formatDate(event.end,
                'Y-MM-DD'); // Formatação do moment.js

                $.ajax({
                    url: '<?php echo site_url('eventos/atualizar/'); ?>' + event
                    .id, //Id do evento a ser atualizado
                    type: 'GET',
                    data: {
                        start: start,
                        end: end,
                    },
                    success: function(response) {
                        exibeMensagem('Atualizado com sucesso!');

                    }, // Fim success

                }); // fim Ajax Atualização
            } // fim else
        }, // Fim atualiza evento

        //Exclusão de evento
        eventClick: function(event) {
            if (event.contapagar_id || event.ordem_id) {
                alert(event.title);
            } else {
                var exibeEvento = confirm(event.title + '\r\n\r' + 'Deseja remover esteve evento?');

                if (exibeEvento) {
                    var confirmaExclusao = confirm(
                        "A exclusão não poderá ser desfeita, tem certeza?")

                    if (confirmaExclusao) {
                        $.ajax({
                            url: '<?php echo site_url('eventos/excluir'); ?>',
                            type: 'GET',
                            data: {
                                id: event.id,
                            },
                            success: function(response) {
                                calendario.fullCalendar('removeEvents', event.id)
                                exibeMensagem('Evento removido com sucesso!');

                            }, // Fim success

                        }); // fim Ajax exclusão

                    } // fim confirma exclusão

                } // fim exibe evento

            } // fim else
        } // fim eventClicl   
    });
});

// Função para exibir msg
function exibeMensagem(mensagem) {
    toastr.success(mensagem, 'Evento');
}
</script>


<?php $this->endSection() ?>