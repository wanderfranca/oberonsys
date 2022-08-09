<?php echo $this->extend('Layout/principal') ?>

<?php echo $this->section('titulo') ?> <?php echo $titulo; ?><?php $this->endSection() ?>
 
<?php echo $this->section('estilos') ?> 

<!-- Estilos -->
<link rel="stylesheet" type="text/css" href="<?php echo site_url('recursos/vendor/datatable/datatables-combinado.min.css'); ?>"/>

<?php $this->endSection() ?>

<!-- Conteúdo -->
<?php echo $this->section('conteudo') ?> 


<div class="row">

<div class="col-lg-12">
                <div class="block">
                  <a href="<?php echo site_url('cpagar/criar');?>" class="btn btn-primary mb-5"> NOVA CONTA A PAGAR </i></a>
                  <div class="row col-lg-5 mb-3 float-right">
                  <div class="form-group col-md-5">
                    <label class="form-control-label">Data Inicial</label>
                    <input type='text' class="form-control" id="kt_daterangepicker_1" readonly placeholder="Select time" type="text"/>
                    </div>
                    <div class="form-group col-1">
                      <button class="btn btn-primary" id="btn_search">Filtrar</button>
                    </div>
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
                          <th></th>
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
<script type="text/javascript" src="<?php echo site_url('recursos/vendor/datatable/datatables-combinado.min.js'); ?>"></script>

<script>
// Class definition

var KTBootstrapDaterangepicker = function () {

// Private functions
var demos = function () {
 // minimum setup
 $('#kt_daterangepicker_1, #kt_daterangepicker_1_modal').daterangepicker({
  buttonClasses: ' btn',
  applyClass: 'btn-primary',
  cancelClass: 'btn-secondary'
 });

 // input group and left alignment setup
 $('#kt_daterangepicker_2').daterangepicker({
  buttonClasses: ' btn',
  applyClass: 'btn-primary',
  cancelClass: 'btn-secondary'
 }, function(start, end, label) {
  $('#kt_daterangepicker_2 .form-control').val( start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
 });

 $('#kt_daterangepicker_2_modal').daterangepicker({
  buttonClasses: ' btn',
  applyClass: 'btn-primary',
  cancelClass: 'btn-secondary'
 }, function(start, end, label) {
  $('#kt_daterangepicker_2 .form-control').val( start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
 });

 // left alignment setup
 $('#kt_daterangepicker_3').daterangepicker({
  buttonClasses: ' btn',
  applyClass: 'btn-primary',
  cancelClass: 'btn-secondary'
 }, function(start, end, label) {
  $('#kt_daterangepicker_3 .form-control').val( start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
 });

 $('#kt_daterangepicker_3_modal').daterangepicker({
  buttonClasses: ' btn',
  applyClass: 'btn-primary',
  cancelClass: 'btn-secondary'
 }, function(start, end, label) {
  $('#kt_daterangepicker_3 .form-control').val( start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
 });


 // date & time
 $('#kt_daterangepicker_4').daterangepicker({
  buttonClasses: ' btn',
  applyClass: 'btn-primary',
  cancelClass: 'btn-secondary',

  timePicker: true,
  timePickerIncrement: 30,
  locale: {
   format: 'MM/DD/YYYY h:mm A'
  }
 }, function(start, end, label) {
  $('#kt_daterangepicker_4 .form-control').val( start.format('MM/DD/YYYY h:mm A') + ' / ' + end.format('MM/DD/YYYY h:mm A'));
 });

 // date picker
 $('#kt_daterangepicker_5').daterangepicker({
  buttonClasses: ' btn',
  applyClass: 'btn-primary',
  cancelClass: 'btn-secondary',

  singleDatePicker: true,
  showDropdowns: true,
  locale: {
   format: 'MM/DD/YYYY'
  }
 }, function(start, end, label) {
  $('#kt_daterangepicker_5 .form-control').val( start.format('MM/DD/YYYY') + ' / ' + end.format('MM/DD/YYYY'));
 });

 // predefined ranges
 var start = moment().subtract(29, 'days');
 var end = moment();

 $('#kt_daterangepicker_6').daterangepicker({
  buttonClasses: ' btn',
  applyClass: 'btn-primary',
  cancelClass: 'btn-secondary',

  startDate: start,
  endDate: end,
  ranges: {
  'Today': [moment(), moment()],
  'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
  'Last 7 Days': [moment().subtract(6, 'days'), moment()],
  'Last 30 Days': [moment().subtract(29, 'days'), moment()],
  'This Month': [moment().startOf('month'), moment().endOf('month')],
  'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
  }
 }, function(start, end, label) {
  $('#kt_daterangepicker_6 .form-control').val( start.format('MM/DD/YYYY') + ' / ' + end.format('MM/DD/YYYY'));
 });
}

return {
 // public functions
 init: function() {
  demos();
 }
};
}();

jQuery(document).ready(function() {
KTBootstrapDaterangepicker.init();
});

</script>
<script src="<?php echo site_url('recursos/');?>vendor/datapicker/daterangepicker.js"> </script>

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

  $(document).ready(function () {

    $('#ajaxTable').DataTable({
        "oLanguage": DATATABLE_PTBR,

        "ajax": '<?php echo site_url('contaspagar/recuperacontaspagar'); ?>',
        "columns": [
            { data: 'situacao' },
            { data: 'descricao_conta' },
            { data: 'razao' },
            { data: 'valor_conta' },
            { data: 'despesa_nome' },
            { data: 'opcoes' },

        ],
        "order": [],
        "deferRender": true,
        "processing": true,
        "responsive": true,
        "pagingType": $(window).width() < 768 ? "simple" : "simple_numbers",

    });

})


</script>

<?php $this->endSection() ?>