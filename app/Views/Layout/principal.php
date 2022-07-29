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
        <link rel="stylesheet" href="<?php echo site_url('recursos/');?>vendor/font-awesome/css/font-awesome.min.css">
        <!-- Custom Font Icons CSS-->
        <link rel="stylesheet" href="<?php echo site_url('recursos/');?>css/font.css">
        <!-- Google fonts - Muli-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">
        <!-- theme stylesheet-->
        <link rel="stylesheet" href="<?php echo site_url('recursos/');?>css/style.blue.css" id="theme-stylesheet">
        <!-- Custom stylesheet - for your changes-->
        <link rel="stylesheet" href="<?php echo site_url('recursos/');?>css/custom.css">
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
                <div class="search-panel">
                    <div class="search-inner d-flex align-items-center justify-content-center">
                        <div class="close-btn">Fechar <i class="fa fa-close"></i></div>
                        <form id="searchForm" action="#">
                            <div class="form-group">
                                <input type="search" name="search" placeholder="O que você está buscando?">
                                <button type="submit" class="submit">Buscar</button>
                            </div>
                        </form>
                    </div>
                </div>
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
                        <div class="list-inline-item"><a href="#" class="search-open nav-link"><i
                                    class="icon-magnifying-glass-browser"></i></a></div>
                        <div class="list-inline-item dropdown"><a id="navbarDropdownMenuLink1" href="http://example.com"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                class="nav-link messages-toggle"><i class="icon-email"></i><span
                                    class="badge dashbg-1">5</span></a>
                            <div aria-labelledby="navbarDropdownMenuLink1" class="dropdown-menu messages"><a href="#"
                                    class="dropdown-item message d-flex align-items-center">
                                    <div class="profile"><img src="img/avatar-3.jpg" alt="..." class="img-fluid">
                                        <div class="status online"></div>
                                    </div>
                                    <div class="content"> <strong class="d-block">Nadia Halsey</strong><span
                                            class="d-block">lorem ipsum dolor sit amit</span><small
                                            class="date d-block">9:30am</small></div>
                                </a><a href="#" class="dropdown-item message d-flex align-items-center">
                                    <div class="profile"><img src="img/avatar-2.jpg" alt="..." class="img-fluid">
                                        <div class="status away"></div>
                                    </div>
                                    <div class="content"> <strong class="d-block">Peter Ramsy</strong><span
                                            class="d-block">lorem ipsum dolor sit amit</span><small
                                            class="date d-block">7:40am</small></div>
                                </a><a href="#" class="dropdown-item message d-flex align-items-center">
                                    <div class="profile"><img src="img/avatar-1.jpg" alt="..." class="img-fluid">
                                        <div class="status busy"></div>
                                    </div>
                                    <div class="content"> <strong class="d-block">Sam Kaheil</strong><span
                                            class="d-block">lorem ipsum dolor sit amit</span><small
                                            class="date d-block">6:55am</small></div>
                                </a><a href="#" class="dropdown-item message d-flex align-items-center">
                                    <div class="profile"><img src="img/avatar-5.jpg" alt="..." class="img-fluid">
                                        <div class="status offline"></div>
                                    </div>
                                    <div class="content"> <strong class="d-block">Sara Wood</strong><span
                                            class="d-block">lorem ipsum dolor sit amit</span><small
                                            class="date d-block">10:30pm</small></div>
                                </a><a href="#" class="dropdown-item text-center message"> <strong>See All Messages <i
                                            class="fa fa-angle-right"></i></strong></a></div>
                        </div>
                        <!-- Tasks-->
                        <div class="list-inline-item dropdown"><a id="navbarDropdownMenuLink2" href="http://example.com"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                class="nav-link tasks-toggle"><i class="icon-new-file"></i><span
                                    class="badge dashbg-3">9</span></a>
                            <div aria-labelledby="navbarDropdownMenuLink2" class="dropdown-menu tasks-list"><a href="#"
                                    class="dropdown-item">
                                    <div class="text d-flex justify-content-between"><strong>Task 1</strong><span>40%
                                            complete</span></div>
                                    <div class="progress">
                                        <div role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0"
                                            aria-valuemax="100" class="progress-bar dashbg-1"></div>
                                    </div>
                                </a><a href="#" class="dropdown-item">
                                    <div class="text d-flex justify-content-between"><strong>Task 2</strong><span>20%
                                            complete</span></div>
                                    <div class="progress">
                                        <div role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0"
                                            aria-valuemax="100" class="progress-bar dashbg-3"></div>
                                    </div>
                                </a><a href="#" class="dropdown-item">
                                    <div class="text d-flex justify-content-between"><strong>Task 3</strong><span>70%
                                            complete</span></div>
                                    <div class="progress">
                                        <div role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"
                                            aria-valuemax="100" class="progress-bar dashbg-2"></div>
                                    </div>
                                </a><a href="#" class="dropdown-item">
                                    <div class="text d-flex justify-content-between"><strong>Task 4</strong><span>30%
                                            complete</span></div>
                                    <div class="progress">
                                        <div role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0"
                                            aria-valuemax="100" class="progress-bar dashbg-4"></div>
                                    </div>
                                </a><a href="#" class="dropdown-item">
                                    <div class="text d-flex justify-content-between"><strong>Task 5</strong><span>65%
                                            complete</span></div>
                                    <div class="progress">
                                        <div role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0"
                                            aria-valuemax="100" class="progress-bar dashbg-1"></div>
                                    </div>
                                </a><a href="#" class="dropdown-item text-center"> <strong>See All Tasks <i
                                            class="fa fa-angle-right"></i></strong></a>
                            </div>
                        </div>
                        <!-- Tasks end-->
                        <!-- Megamenu-->
                        <div class="list-inline-item dropdown menu-large"><a href="#" data-toggle="dropdown"
                                class="nav-link">Mega <i class="fa fa-ellipsis-v"></i></a>
                            <div class="dropdown-menu megamenu">
                                <div class="row">
                                    <div class="col-lg-3 col-md-6"><strong class="text-uppercase">Elements
                                            Heading</strong>
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
                                    <div class="col-lg-3 col-md-6"><strong class="text-uppercase">Elements
                                            Heading</strong>
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
                            </div>
                        </div>
                        <!-- Megamenu end     -->

                        <div class="dropdown show list-inline-item ">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opções do Usuário
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                
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
                    <div class="avatar"><img src="#" alt="..." class="img-fluid rounded-circle"></div>
                    <div class="title">
                        <h6>DESENVOLVIMENTO</h6>
                        <p>CEO Oberon</p>
                    </div>
                </div>
                <!-- Sidebar Navidation Menus--><span class="heading">Menu</span>
                <ul class="list-unstyled">
                <li class="<?php echo (url_is('/') ? 'active' : '') ?>"><a href="<?php echo site_url('/'); ?>">Início </a></li>

                <li>
                    <a href="#cadastrosDropdown" aria-expanded="<?php echo (url_is('fornecedores') | url_is('itens') | url_is('clientes') ? 'true' : 'false') ?>" data-toggle="collapse">Cadastros</a>
                    <ul id="cadastrosDropdown" class="<?php echo (url_is('fornecedores') | url_is('itens')| url_is('clientes') ? '' : 'collapse') ?> list-unstyled ">
                        <li class="<?php echo (url_is('itens') ? 'active' : '') ?>"><a href="<?php echo site_url('itens'); ?>">Produtos</a></li>
                        <li class="<?php echo (url_is('fornecedores')  ? 'active' : '') ?>"><a href="<?php echo site_url('fornecedores'); ?>">Fornecedores</a></li>
                        <li class="<?php echo (url_is('clientes') ? 'active' : '') ?>"><a href="<?php echo site_url('clientes'); ?>">Clientes</a></li>
                    </ul>

                    <li>
                    <a href="#gestaoFinDropdown" aria-expanded="<?php echo (url_is('contasbancarias') ? 'true' : 'false') ?>" data-toggle="collapse">Financeiro</a>
                    <ul id="gestaoFinDropdown" class="<?php echo (url_is('contasbancarias')  ? '' : 'collapse') ?> list-unstyled ">
                        <li class="<?php echo (url_is('#') ? 'active' : '') ?>"><a href="<?php echo site_url('#'); ?>">Contas a Pagar </a></li>
                        <li class="<?php echo (url_is('#') ? 'active' : '') ?>"><a href="<?php echo site_url('#'); ?>">Contas a Receber </a></li>
                        <li class="<?php echo (url_is('contasbancarias') ? 'active' : '') ?>"><a href="<?php echo site_url('contasbancarias'); ?>">Informações Bancárias </a></li>
                    </ul>


                    <li>
                    <a href="#gestaoDropdown" aria-expanded="<?php echo (url_is('fornecedores/excluidos') | url_is('itens/produtosexcluidos') | url_is('clientes/excluidos') ? 'true' : 'false') ?>" data-toggle="collapse">Gestão de Cadastros</a>
                    <ul id="gestaoDropdown" class="<?php echo (url_is('fornecedores/excluidos') | url_is('itens/produtosexcluidos') | url_is('itens/servicosexcluidos') | url_is('clientes/excluidos') ? '' : 'collapse') ?> list-unstyled ">
                        <li class="<?php echo (url_is('clientes/excluidos') ? 'active' : '') ?>"><a href="<?php echo site_url('clientes/excluidos'); ?>">Clientes Excluídos </a></li>
                        <li class="<?php echo (url_is('itens/produtosexcluidos') ? 'active' : '') ?>"><a href="<?php echo site_url('itens/produtosexcluidos'); ?>">Produtos Excluídos</a></li>
                        <li class="<?php echo (url_is('itens/servicosexcluidos') ? 'active' : '') ?>"><a href="<?php echo site_url('itens/servicosexcluidos'); ?>">Serviços Excluídos</a></li>
                        <li class="<?php echo (url_is('fornecedores/excluidos') ? 'active' : '') ?>"><a href="<?php echo site_url('fornecedores/excluidos'); ?>">Fornecedores Excluídos</a></li>
                    </ul>
                    
                    <li><a href="#tabelasDropdown" aria-expanded="<?php echo (url_is('categorias') | url_is('itens') ? 'true' : 'false') ?>" data-toggle="collapse">Tabelas</a>
                    <ul id="tabelasDropdown" class="collapse list-unstyled ">
                      <!-- Sidebar Navidation Menus--><span class="heading">Produtos</span>    
                        <li class="<?php echo (url_is('categorias/*') ? 'active' : '') ?>"><a href="<?php echo site_url('categorias'); ?>">Categorias </a></li>
                            <li><a href="#">Page</a></li>
                            <li><a href="#">Page</a></li>
                        </ul>
                    </li>

                    <li>
                    <a href="#usuariosDropdown" aria-expanded="<?php echo (url_is('usuarios') | url_is('usuarios/editarsenha') | url_is('grupos') ? 'true' : 'false') ?>" data-toggle="collapse">Usuários</a>
                    <ul id="usuariosDropdown" class="<?php echo (url_is('usuarios') | url_is('usuarios/editarsenha') | url_is('grupos') ? '' : 'collapse') ?> list-unstyled ">
                        <li class="<?php echo (url_is('usuarios') ? 'active' : '') ?>"><a href="<?php echo site_url('usuarios'); ?>">Usuários </a></li>
                        <li class="<?php echo (url_is('grupos/*') ? 'active' : '') ?>"><a href="<?php echo site_url('grupos'); ?>">Grupos & Permissões </a></li>
                        <li class="<?php echo (url_is('usuarios/editarsenha') ? 'active' : '') ?>"><a href="<?php echo site_url('usuarios/editarsenha'); ?>">Alterar senha </a></li>
                    </ul>

                    <li><a href="#"> Relatórios </a></li>
                    <li><a href="#"> Configurações </a></li>
               
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
        <script src="<?php echo site_url('recursos/');?>js/front.js"></script>
        <script src="<?php echo site_url('recursos/');?>js/close-alert.js"></script>

        <!-- ESPAÇO RESERVADO PARA RENDERIZAR OS SCRIPTS DE CADA VIEW E EXTENDER O LAYOUT -->
        <?php echo $this->renderSection('scripts'); ?>

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