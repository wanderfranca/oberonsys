<?php echo $this->extend('Layout/principal') ?>

<?php echo $this->section('titulo') ?> <?php echo $titulo; ?><?php $this->endSection() ?>

<?php echo $this->section('estilos') ?>

<!-- Estilos -->
<link rel="stylesheet" type="text/css"
    href="<?php echo site_url('recursos/vendor/datatable/datatables-combinado.min.css'); ?>" />

<?php $this->endSection() ?>

<!-- Conteúdo -->
<?php echo $this->section('conteudo') ?>



<div class="row">

    <div class="col-lg-12">
        <div class="block">
            <a href="<?php echo site_url('cpagar/criar');?>" class="btn btn-primary mb-5"> NOVA CONTA A PAGAR </i></a>
            <div class="row datepicker">

                <div class="col-sm-3">
                    <label class="control-label">Data Inicial</label>
                    <input class="form-control datepicker datepickershow ptdate" required type="text" name="initial_date"
                        id="initial_date" autocomplete="off" readonly   placeholder="dd-mm-aaaa"
                        style="height: 40px;" />
                </div>
                <div class="col-sm-3">
                    <label class="control-label">Data Final</label>
                    <input class="form-control datepicker datepickershow ptdate" required type="text" name="final_date"
                        id="final_date" autocomplete="off" readonly  placeholder="dd-mm-aaaa"
                        style="height: 40px;" />
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-success btn-block" type="submit" name="filter" id="filter"
                        style="margin-top: 30px">
                        <i class="fa fa-filter"></i> Buscar
                    </button>

                    <div class="col-sm-12 text-danger" id="error_log"></div>
                </div>
            </div>
            <div class="form-group col-1">
            </div>
           
            <div class="table-responsive">
                <table id="ajaxTable" class="table table-striped table-sm" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Situação</th>
                            <th>Descrição</th>
                            <th>Fornecedor</th>
                            <th>Valor</th>
                            <th>Despesa</th>
                            <th>Vencimento</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
 


</div>

<?php $this->endSection() ?>

<!-- Scripts -->
<?php echo $this->section('scripts') ?>
<script type="text/javascript" src="<?php echo site_url('recursos/vendor/datatable/datatables-combinado.min.js'); ?>">
</script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
<script src="<?php echo site_url('recursos/vendor/bootstrap/js/bootstrap-datepicker.js'); ?>"></script>


<script>
const DATATABLE_PTBR = {
    "sEmptyTable": "Nenhum registro encontrado",
    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
    "sInfoPostFix": "",
    "sInfoThousands": ".",
    "sLengthMenu": "_MENU_ resultados por página",
    "sLoadingRecords": "Carregando...",
    "sProcessing": "Processando...",
    "sZeroRecords": "Nenhum registro encontrado",
    "sSearch": "Pesquisar",
    "oPaginate": {
        "sNext": ">",
        "sPrevious": "<",
        "sFirst": "Primeiro",
        "sLast": "Último"
    },
    "oAria": {
        "sSortAscending": ": Ordenar colunas de forma ascendente",
        "sSortDescending": ": Ordenar colunas de forma descendente"
    },
    "select": {
        "rows": {
            "_": "Selecionado %d linhas",
            "0": "Nenhuma linha selecionada",
            "1": "Selecionado 1 linha"
        }
    }
}

load_data(); // first load

function load_data(initial_date, final_date) {
    var ajax_url = '<?php echo site_url('cpagar/recuperacontaspagar'); ?>';

   var tabela = $('#ajaxTable').DataTable({
        "oLanguage": DATATABLE_PTBR,
        "order": [],
        "responsive" : true,  
        dom: 'Blfrtip', // Add the Copy, Print and export to CSV, Excel and PDF buttons
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "processing": true,
        "ajax": {
            "url": ajax_url,
            "dataType": "json",
            "type": "GET",
            "data": {
                "action": "ajaxTable",
                "initial_date": $("#initial_date").val(),
                "final_date":  $("#final_date").val(),
                "stateSave": true,
                "bDestroy": true
            },

        },
        "columns": [{
                data: 'situacao'
            },
            {
                data: 'descricao_conta'
            },
            {
                data: 'razao'
            },
            {
                data: 'valor_conta'
            },
            {
                data: 'despesa_nome'
            },
            {
                data: 'data_vencimento'
            },

        ]


    });
}

$("#filter").click(function() {
    var initial_date = $("#initial_date").val();
    var final_date = $("#final_date").val();

    if (initial_date == undefined && final_date == undefined) {
        $("#error_log").html("<span>Informe um período inicial e final</span>");
    } else {
        var date1 = new Date(initial_date);
        var date2 = new Date(final_date);
        var diffTime = Math.abs(date2 - date1);
        var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

        if (initial_date == undefined || final_date == undefined) {
            $("#error_log").html("<span>Informe um período inicial e final</span>");
        } else {
            if (date1 > date2) {
                $("#error_log").html("Período inicial não pode ser superior ao final");
            } else {
                $("#error_log").html("");
                $('#ajaxTable').DataTable().destroy();
                load_data(initial_date, final_date);
                
            }
        }
    }
});

$('.datepickershow').datepicker({
    todayBtn: 'linked',
    format: "yyyy-mm-dd",
    autoclose: true
});

$(function() {
    $('.datepickershow').datepicker();
    $('.datepickershow').datepicker('hidden');


});
</script>


<?php $this->endSection() ?>