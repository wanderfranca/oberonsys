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
    $routes->get('blog', 'Admin\Blog::index');
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
