<?php echo $this->extend('Layout/principal') ?>

<?php echo $this->section('titulo') ?> <?php echo strtoupper($titulo); ?> <?php $this->endSection() ?>

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
            <div class="content-fluid mb-4">
                <h5><?php echo $titulo_visaogeral; ?></h5>
            </div>
            <a href="<?php echo site_url('itens/criar');?>" class="btn btn-primary text-white mb-5 mr-1"> NOVO PRODUTO </i></a>
            <a href="<?php echo site_url('itens/produtosexcluidos');?>" class="btn btn-danger mb-5 mr-1 text-white"> PRODUTOS EXCLUÍDOS </a>
            <a href="<?php echo site_url('itens/servicosexcluidos');?>" class="btn btn-danger mb-5 mr-1 text-white"> SERVIÇOS EXCLUÍDOS </a>

            <div class="block">
                <table id="ajaxTable" class="table table-striped table-sm" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Código</th>
                            <th>Tipo</th>
                            <th>Estoque</th>
                            <th>Preço Venda</th>
                            <th>Situação</th>
                        </tr>
                    </thead>
                </table>
            </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
        <div class="block">
            <h5 class="mb-3">Saldo Zerado</h5>
        <table id="zeroEstoque" class="table table-striped table-sm" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Código</th>
                            <th>Preço Venda</th>
                            <th>Situação</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
  

        <div class="col-lg-6">
        <div class="block">
            <h5 class="mb-3">Saldo Menor que zero</h5>
        <table id="estoqueNegativo" class="table table-striped table-sm" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Código</th>
                            <th>Estoque</th>
                            <th>Preço Venda</th>
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
<script type="text/javascript" src="<?php echo site_url('recursos/vendor/datatable/datatables-combinado.min.js'); ?>">
</script>

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

$(document).ready(function() {

    // Tabela de itens em geral
    $('#ajaxTable').DataTable({
        "oLanguage": DATATABLE_PTBR,

        "ajax": '<?php echo site_url('itens/recuperaitens'); ?>',
        "columns": [{
                data: 'nome'
            },
            {
                data: 'codigo_interno'
            },
            {
                data: 'tipo'
            },
            {
                data: 'estoque'
            },
            {
                data: 'preco_venda'
            },
            {
                data: 'situacao'
            },

        ],
        "order": [],
        "deferRender": true,
        "processing": true,
        "responsive": true,
        "pagingType": $(window).width() < 768 ? "simple" : "simple_numbers",

    });

    // Tabela de itens com saldo zerado
    $('#zeroEstoque').DataTable({
        "oLanguage": DATATABLE_PTBR,

        "ajax": '<?php echo site_url('itens/recuperaitensestoquezerado'); ?>',
        "columns": [{
                data: 'nome'
            },
            {
                data: 'codigo_interno'
            },
            {
                data: 'preco_venda'
            },
            {
                data: 'situacao'
            },

        ],
        "order": [],
        "deferRender": true,
        "processing": true,
        "responsive": true,
        "pagingType": $(window).width() < 768 ? "simple" : "simple_numbers",
        "filter": false,
        "lengthChange": false
    });

    // Tabela de itens com saldo negativo
    $('#estoqueNegativo').DataTable({
        
        "oLanguage": DATATABLE_PTBR,

        "ajax": '<?php echo site_url('itens/recuperaitensnegativos'); ?>',
        "columns": [{
                data: 'nome'
            },
            {
                data: 'codigo_interno'
            },
            {
                data: 'estoque'
            },
            {
                data: 'preco_venda'
            },
            {
                data: 'situacao'
            },

        ],
        
        "order": [],
        "deferRender": true,
        "processing": true,
        "responsive": true,
        "pagingType": $(window).width() < 768 ? "simple" : "simple_numbers",
        "filter": false,
        "lengthChange": false
    });



});
</script>

<?php $this->endSection() ?>