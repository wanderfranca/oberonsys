<?php echo $this->extend('Layout/principal') ?>

<?php echo $this->section('titulo') ?> <?php echo $titulo; ?><?php $this->endSection() ?>

<!-- Estilos -->
<?php echo $this->section('estilos') ?> 
<?php $this->endSection() ?>

<!-- Conteúdo -->
<?php echo $this->section('conteudo') ?> 
<?php $this->endSection() ?>

<!-- Scripts -->
<?php echo $this->section('scripts') ?> 
<?php $this->endSection() ?>