<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Oberon Sistema <?php //echo $this->renderSection('titulo'); ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="all,follow">
        <!-- Bootstrap CSS-->
        <link rel="stylesheet" href="<?php echo site_url('recursos/');?>vendor/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome CSS-->
        <link rel="stylesheet" href="<?php echo site_url('recursos/');?>vendor/font-awesome/css/fontawesome4.min.css">
        <!-- Custom Font Icons CSS-->
        <link rel="stylesheet" href="<?php echo site_url('recursos/');?>css/font.css">
        <!-- Google fonts - Muli-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">
        <!-- theme stylesheet-->
        <link rel="stylesheet" href="<?php echo site_url('recursos/');?>css/style.blue.css" id="theme-stylesheet">
        <!-- Custom stylesheet - for your changes-->
        <link rel="stylesheet" href="<?php echo site_url('recursos/');?>css/custom.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.standalone.min.css">
        <!-- Favicon-->
        <link rel="shortcut icon" href="<?php echo site_url('recursos/');?>img/favicon.ico">
        <!-- Tweaks for older IEs-->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->

        <!-- ESPAÇO RESERVADO PARA RENDERIZAR OS ESTILOS DE CADA VIEW E EXTENDER O LAYOUT -->
        <?php echo $this->renderSection('estilos'); ?>

    </head>

    <body>
        <header class="header">
            <nav class="navbar navbar-expand-lg">

                <div class="container-fluid d-flex align-items-center justify-content-between">
                    <div class="navbar-header">
                        <!-- Navbar Header--><a href="<?php echo site_url('/') ?>" class="navbar-brand">
                            <div class="brand-text brand-big visible text-uppercase"><strong
                                    class="text-primary">Oberon</strong><strong>Sys</strong></div>
                            <div class="brand-text brand-sm"><strong class="text-primary">OB</strong><strong>N</strong>
                            </div>
                        </a>
                        <!-- Sidebar Toggle Btn-->
                        <button class="sidebar-toggle"><i class="fa fa-long-arrow-left"></i></button>
                    </div>
                    <div class="right-menu list-inline no-margin-bottom">

                       
                        <!-- Megamenu-->
                        <div class="list-inline-item dropdown menu-large"><a href="#" data-toggle="dropdown" class="nav-link">Menu Geral <i class="fa fa-list"></i></a>
                                <div class="dropdown-menu megamenu">
                                    <div class="row">
                                    <div class="col-lg-3 col-md-6"><strong class="text-uppercase">Elements Heading</strong>
                                        <ul class="list-unstyled mb-3">
                                        <li><a href="#">Lorem ipsum dolor</a></li>
                                        <li><a href="#">Sed ut perspiciatis</a></li>
                                        <li><a href="#">Voluptatum deleniti</a></li>
                                        <li><a href="#">At vero eos</a></li>
                                        <li><a href="#">Consectetur adipiscing</a></li>
                                        <li><a href="#">Duis aute irure</a></li>
                                        <li><a href="#">Necessitatibus saepe</a></li>
                                        <li><a href="#">Maiores alias</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-3 col-md-6"><strong class="text-uppercase">Elements Heading</strong>
                                        <ul class="list-unstyled mb-3">
                                        <li><a href="#">Lorem ipsum dolor</a></li>
                                        <li><a href="#">Sed ut perspiciatis</a></li>
                                        <li><a href="#">Voluptatum deleniti</a></li>
                                        <li><a href="#">At vero eos</a></li>
                                        <li><a href="#">Consectetur adipiscing</a></li>
                                        <li><a href="#">Duis aute irure</a></li>
                                        <li><a href="#">Necessitatibus saepe</a></li>
                                        <li><a href="#">Maiores alias</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-3 col-md-6"><strong class="text-uppercase">Elements Heading</strong>
                                        <ul class="list-unstyled mb-3">
                                        <li><a href="#">Lorem ipsum dolor</a></li>
                                        <li><a href="#">Sed ut perspiciatis</a></li>
                                        <li><a href="#">Voluptatum deleniti</a></li>
                                        <li><a href="#">At vero eos</a></li>
                                        <li><a href="#">Consectetur adipiscing</a></li>
                                        <li><a href="#">Duis aute irure</a></li>
                                        <li><a href="#">Necessitatibus saepe</a></li>
                                        <li><a href="#">Maiores alias</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-3 col-md-6"><strong class="text-uppercase">Elements Heading</strong>
                                        <ul class="list-unstyled mb-3">
                                        <li><a href="#">Lorem ipsum dolor</a></li>
                                        <li><a href="#">Sed ut perspiciatis</a></li>
                                        <li><a href="#">Voluptatum deleniti</a></li>
                                        <li><a href="#">At vero eos</a></li>
                                        <li><a href="#">Consectetur adipiscing</a></li>
                                        <li><a href="#">Duis aute irure</a></li>
                                        <li><a href="#">Necessitatibus saepe</a></li>
                                        <li><a href="#">Maiores alias</a></li>
                                        </ul>
                                    </div>
                                    </div>
                                    <div class="row megamenu-buttons text-center">
                                    <div class="col-lg-2 col-md-4"><a href="#" class="d-block megamenu-button-link dashbg-1"><i class="fa fa-clock-o"></i><strong>Demo 1</strong></a></div>
                                    <div class="col-lg-2 col-md-4"><a href="#" class="d-block megamenu-button-link dashbg-2"><i class="fa fa-clock-o"></i><strong>Demo 2</strong></a></div>
                                    <div class="col-lg-2 col-md-4"><a href="#" class="d-block megamenu-button-link dashbg-3"><i class="fa fa-clock-o"></i><strong>Demo 3</strong></a></div>
                                    <div class="col-lg-2 col-md-4"><a href="#" class="d-block megamenu-button-link dashbg-4"><i class="fa fa-clock-o"></i><strong>Demo 4</strong></a></div>
                                    <div class="col-lg-2 col-md-4"><a href="#" class="d-block megamenu-button-link bg-danger"><i class="fa fa-clock-o"></i><strong>Demo 5</strong></a></div>
                                    <div class="col-lg-2 col-md-4"><a href="#" class="d-block megamenu-button-link bg-info"><i class="fa fa-clock-o"></i><strong>Demo 6</strong></a></div>
                                    </div>
                                </div>
                            </div>
                        <!-- Megamenu end     -->

                    <div class="dropdown show list-inline-item ">
                        <a class="dropdown-toggle nav-link" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opções do Usuário
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="<?php echo site_url("usuarios/exibir/" . usuario_logado()->id) ?>">Meu Perfil</a>
                            <a class="dropdown-item" href="<?php echo site_url("usuarios/editarsenha") ?>">Alterar senha</a>
                            <a class="dropdown-item" href="<?php echo site_url('logout') ?>">Sair do sistema</a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <div class="d-flex align-items-stretch">
        <!-- Sidebar Navigation-->
        <nav id="sidebar">
            <!-- Sidebar Header-->
            <div class="sidebar-header d-flex align-items-center">

            <?php if(usuario_logado()->imagem === null): ?>

                <div class="avatar"><img src="<?php echo site_url("recursos/img/usuario_sem_imagem.png"); ?>" alt="<?php echo esc(usuario_logado()->nome); ?>" class="img-fluid rounded-circle"></div>

                <?php else: ?>

                    <div class="avatar"><img src="<?php echo site_url("usuarios/imagem/". usuario_logado()->imagem); ?>" alt="<?php echo esc(usuario_logado()->nome); ?>" class="img-fluid rounded-circle"></div>


                <?php endif; ?>
                <div class="title">
                    <h1 class="h5"><?php echo esc(usuario_logado()->nome); ?></h1>
                    <?php if(usuario_logado()->is_admin): ?>
                    <p>Administrador</p>
                    <?php endif; ?>

                    <?php if(!usuario_logado()->is_admin && !usuario_logado()->is_cliente): ?>
                    <p>Operacional</p>
                    <?php endif; ?>

                    <?php if(usuario_logado()->is_cliente): ?>
                    <p>Cliente</p>
                    <?php endif; ?>
                </div>
            </div>
            <!-- Sidebar Navidation Menus--><span class="heading">Menu</span>
            <ul class="list-unstyled">
            <li class="<?php echo (url_is('/') ? 'active' : '') ?>"><a href="<?php echo site_url('/'); ?>"><i class="icon-home"></i>Início </a></li>
            <li class="<?php echo (url_is('ordens') ? 'active' : '') ?>"><a href="<?php echo site_url('ordens'); ?>"><i class="icon-list"></i>Ordens de Serviço </a></li>
            <li>
                <a href="#cadastrosDropdown" aria-expanded="<?php echo (url_is('fornecedores') | url_is('itens') | url_is('clientes') ? 'true' : 'false') ?>" data-toggle="collapse"><i class="fa fa-folder"></i>Cadastros</a>
                <ul id="cadastrosDropdown" class="<?php echo (url_is('fornecedores') | url_is('itens')| url_is('clientes') ? '' : 'collapse') ?> list-unstyled ">
                    <li class="<?php echo (url_is('itens') ? 'active' : '') ?>"><a href="<?php echo site_url('itens'); ?>">Produtos</a></li>
                    <li class="<?php echo (url_is('fornecedores')  ? 'active' : '') ?>"><a href="<?php echo site_url('fornecedores'); ?>">Fornecedores</a></li>
                    <li class="<?php echo (url_is('clientes') ? 'active' : '') ?>"><a href="<?php echo site_url('clientes'); ?>">Clientes</a></li>
                </ul>

                <!-- FINANCEIRO  -->
            <li>
                <a href="#gestaoFinDropdown" aria-expanded="<?php echo (url_is('creceber') || url_is('cpagar') ? 'true' : 'false') ?>" data-toggle="collapse"><i class="fa fa-money"></i>Financeiro</a>
                <ul id="gestaoFinDropdown" class="<?php echo (url_is('creceber') || url_is('cpagar') ? '' : 'collapse') ?> list-unstyled ">
                    <li class="<?php echo (url_is('cpagar') ? 'active' : '') ?>"><a href="<?php echo site_url('cpagar'); ?>">Contas a Pagar </a></li>
                    <!-- <li class="<?php echo (url_is('#') ? 'active' : '') ?>"><a href="<?php echo site_url('#'); ?>">Contas a Receber </a></li> -->
                </ul>

                <li class="<?php echo (url_is('eventos') ? 'active' : '') ?>"><a href="<?php echo site_url('eventos'); ?>"><i class="fa fa-calendar"></i>Eventos </a></li>

                <!-- GESTÃO DE CADASTROS  -->
            <li>
                <a href="#gestaoDropdown" aria-expanded="<?php echo (url_is('fornecedores/excluidos') | url_is('itens/produtosexcluidos') | url_is('clientes/excluidos') ? 'true' : 'false') ?>" data-toggle="collapse"><i class="icon-windows"></i>Gestão de Cadastros</a>
                <ul id="gestaoDropdown" class="<?php echo (url_is('fornecedores/excluidos') | url_is('itens/produtosexcluidos') | url_is('itens/servicosexcluidos') | url_is('clientes/excluidos') ? '' : 'collapse') ?> list-unstyled ">
                    <li class="<?php echo (url_is('clientes/excluidos') ? 'active' : '') ?>"><a href="<?php echo site_url('clientes/excluidos'); ?>">Clientes Excluídos </a></li>
                    <li class="<?php echo (url_is('itens/produtosexcluidos') ? 'active' : '') ?>"><a href="<?php echo site_url('itens/produtosexcluidos'); ?>">Produtos Excluídos</a></li>
                    <li class="<?php echo (url_is('itens/servicosexcluidos') ? 'active' : '') ?>"><a href="<?php echo site_url('itens/servicosexcluidos'); ?>">Serviços Excluídos</a></li>
                    <li class="<?php echo (url_is('fornecedores/excluidos') ? 'active' : '') ?>"><a href="<?php echo site_url('fornecedores/excluidos'); ?>">Fornecedores Excluídos</a></li>
                </ul>
                
                <!-- TABELAS -->
            <li>
                <a href="#tabelasDropdown" aria-expanded="<?php echo (url_is('categorias') |url_is('contasbancarias') | url_is('formas') | url_is('despesas') ? 'true' : 'false') ?>" data-toggle="collapse"><i class="fa fa-table"></i>Tabelas</a>
                <ul id="tabelasDropdown" class="<?php echo (url_is('categorias') | url_is('contasbancarias') |url_is('formas') | url_is('despesas') ? '' : 'collapse') ?> list-unstyled ">
                    
                    <!-- DIVISAO Menus--><span class="heading">Produtos</span>    
                    <li class="<?php echo (url_is('categorias') ? 'active' : '') ?>"><a href="<?php echo site_url('categorias'); ?>">Categorias </a></li>

                    <!-- DIVISAO Menus--><span class="heading">Financeiro</span>
                    <li class="<?php echo (url_is('despesas') ? 'active' : '') ?>"><a href="<?php echo site_url('despesas'); ?>">Despesas </a></li>
                    <li class="<?php echo (url_is('formas') ? 'active' : '') ?>"><a href="<?php echo site_url('formas'); ?>">Formas de Pagamentos </a></li>
                    <li class="<?php echo (url_is('contasbancarias') ? 'active' : '') ?>"><a href="<?php echo site_url('contasbancarias'); ?>">Informações Bancárias </a></li>    
                    
                    </ul>
                </li>

                <!-- USUÁRIOS -->
            <li>
                <a href="#usuariosDropdown" aria-expanded="<?php echo (url_is('usuarios') | url_is('usuarios/editarsenha') | url_is('grupos') ? 'true' : 'false') ?>" data-toggle="collapse"><i class="fa fa-users"></i>Usuários</a>
                <ul id="usuariosDropdown" class="<?php echo (url_is('usuarios') | url_is('usuarios/editarsenha') | url_is('grupos') ? '' : 'collapse') ?> list-unstyled ">
                    <li class="<?php echo (url_is('usuarios') ? 'active' : '') ?>"><a href="<?php echo site_url('usuarios'); ?>">Usuários </a></li>
                    <li class="<?php echo (url_is('grupos/*') ? 'active' : '') ?>"><a href="<?php echo site_url('grupos'); ?>">Grupos & Permissões </a></li>
                    <li class="<?php echo (url_is('usuarios/editarsenha') ? 'active' : '') ?>"><a href="<?php echo site_url('usuarios/editarsenha'); ?>">Alterar senha </a></li>
                </ul>
                <!-- /USUÁRIOS -->
                <li><a href="#"><i class="icon-chart"></i> Relatórios </a></li>
                <li><a href="#"><i class="icon-settings"></i> Configurações </a></li>
        
        </nav>
        <!-- Sidebar Navigation end-->
        <div class="page-content">
            <div class="page-header">
                <div class="container-fluid">
                    <h2 class="h5 no-margin-bottom"><?php echo $titulo; ?></h2>
                </div>
            </div>
            <section class="no-padding-top no-padding-bottom">

                <div class="container-fluid">

                    <?php echo $this->include('Layout/_mensagens'); ?>

                    <!-- ESPAÇO RESERVADO PARA RENDERIZAR O CONTEÚDO DE CADA VIEW E EXTENDER O LAYOUT -->
                    <?php echo $this->renderSection('conteudo'); ?>

                </div>

            </section>


            <footer class="footer">
                <div class="footer__block block no-margin-bottom">
                    <div class="container-fluid text-center">
                        <p class="no-margin-bottom"><?php echo date('Y')?> &copy; Para suporte, entre em contato
                            conosco <a target="_blank" href="https://suporteoberon.com.br">Suporte Oberon</a>.</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- JavaScript files-->
    <script src="<?php echo site_url('recursos/');?>vendor/jquery/jquery.min.js"></script> 
    <script src="<?php echo site_url('recursos/');?>vendor/popper.js/umd/popper.min.js"> </script>
    <script src="<?php echo site_url('recursos/');?>vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script> 
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> 
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script> 
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script> 
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script> 
    <script src="<?php echo site_url('recursos/');?>js/front.js"></script>
    <script src="<?php echo site_url('recursos/');?>js/close-alert.js"></script>

    <!-- SCRIPTS -->
    <?php echo $this->renderSection('scripts'); ?>

    <?php if(url_is('eventos')): ?>
    <!-- carregar no Full Calendar -->
    <script src="<?php echo site_url('recursos/vendor/fullcalendar/fullcalendar.min.js');?>"></script>
    <script src="<?php echo site_url('recursos/vendor/fullcalendar/locale/pt-br.js');?>"></script>
    <script src="<?php echo site_url('recursos/vendor/fullcalendar/toastr.min.js');?>"></script>
    <script src="<?php echo site_url('recursos/vendor/fullcalendar/moment.min.js');?>"></script>
    <?php endif; ?>

    <script>
    $(function() {
        $('[data-toggle="popover"]').popover({

            html: true,

        });
    })



    $("#alert-danger").fadeTo(7000, 700).slideUp(700, function() {
        $("#alert-danger").slideUp(700);
    });
    </script>
</body>

</html>