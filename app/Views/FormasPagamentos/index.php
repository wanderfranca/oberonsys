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
                  <a href="<?php echo site_url('formas/criar');?>" class="btn btn-primary mb-5"> CADASTRAR FORMA DE PAGAMENTO </i></a>
                  <div class="table-responsive"> 
                    <table id="ajaxTable" class="table table-striped table-sm" style="width: 100%;">
                      <thead>
                        <tr>
                          <th>Forma de Pagamento</th>
                          <th>Descrição</th>
                          <th>Data de Cadastro</th>
                          <th>Situação</th>
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

        $(document).ready(function () {

        $('#ajaxTable').DataTable({
            "oLanguage": DATATABLE_PTBR,

            "ajax": '<?php echo site_url('formas/recuperaFormas'); ?>',
            "columns": [
                { data: 'nome' },
                { data: 'descricao' },
                { data: 'criado_em' },
                { data: 'situacao' },

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