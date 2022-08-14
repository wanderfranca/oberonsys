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


    });

</script>

<?php $this->endSection() ?>