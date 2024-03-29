<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// routes->get('nome_na_URL', 'Controller', 'Método')
$routes->get('/', 'Home::index');
$routes->get('login', 'Login::novo');
$routes->get('logout', 'Login::logout');
$routes->get('esqueci', 'Password::esqueci');

//Grupo de rotas: Contas Pagar
$routes->group('cpagar', static function($routes) 
{
    $routes->get('/', 'ContasPagar::index');
    $routes->get('recuperacontaspagar', 'ContasPagar::recuperaContasPagar');
    $routes->get('buscaFornecedores', 'ContasPagar::buscaFornecedores');
    $routes->get('exibir/(:segment)', 'ContasPagar::exibir/$1');
    $routes->get('editar/(:segment)', 'ContasPagar::editar/$1');
    $routes->get('criar/', 'ContasPagar::criar');

    //POST
    $routes->post('cadastrar', 'ContasPagar::cadastrar');
    $routes->post('atualizar', 'ContasPagar::atualizar');

    //GET e POST
    $routes->match(['get','post'], 'excluir/(:segment)', 'ContasPagar::excluir/$1');

});


// Grupo de rodas: Formas de pagamentos
$routes->group('formas', static function($routes)
{

    $routes->add('/', 'FormasPagamentos::index');
    $routes->get('recuperaFormas', 'FormasPagamentos::recuperaFormas');

    $routes->get('exibir/(:segment)', 'FormasPagamentos::exibir/$1');
    $routes->get('editar/(:segment)', 'FormasPagamentos::editar/$1');
    $routes->get('criar/', 'FormasPagamentos::criar');

    //POST
    $routes->post('cadastrar', 'FormasPagamentos::cadastrar');
    $routes->post('atualizar', 'FormasPagamentos::atualizar');

    //GET e POST
    $routes->match(['get','post'], 'excluir/(:segment)', 'FormasPagamentos::excluir/$1');

}); 


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) 
{
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
