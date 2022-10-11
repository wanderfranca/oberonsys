<?php echo $this->extend('Layout/principal') ?>

<?php echo $this->section('titulo') ?> <?php echo $titulo; ?><?php $this->endSection() ?>

<!-- Estilos -->
<?php echo $this->section('estilos') ?>
<?php $this->endSection() ?>

<!-- Conteúdo -->
<?php echo $this->section('conteudo') ?>

<div class="row">

    <div class="col-lg-6">

        <div class="block">

            <div class="block-body">

                <?php echo form_open("clientes/excluir/$cliente->id")  ?>

                <div class="alert alert-warning" role="alert">
                    Tem certeza que deseja desativar este cliente?
                </div>

                <div class="form-group mt-5 mb-2">
                    <input id="btn-salvar" type="submit" value="Sim, desejo desativar" class="btn btn-danger btn-sm mr-1">
                    <a href="<?php echo site_url("clientes/exibir/$cliente->id") ?>" class="btn btn-secondary btn-sm ml-1">Cancelar</a>

                </div>

                <?php echo form_close(); ?>

            </div>


        </div> <!-- FIM DO DIV BLOCK -->



    </div>

</div>


<?php $this->endSection() ?>

<!-- Scripts -->
<?php echo $this->section('scripts') ?>


<?php $this->endSection() ?>