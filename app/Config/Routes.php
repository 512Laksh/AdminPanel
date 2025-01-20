<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('log', 'LoginController::index');
$routes->get('sign', 'SignupController::index');

$routes->post('signup', 'SignupController::signup');
$routes->post('login', 'LoginController::login');

// $routes->get('dashboard', 'UserController::index');
$routes->post('filter', 'Home::Filter');

$routes->get('usertable', 'Home::showUser');
$routes->get('addUser', 'Home::getaddUser');


$routes->post('store', 'SignupController::store');
$routes->get('delete/(:num)', 'Home::deleteUser/$1');

// $routes->post('update/(:any)','Home::update/$1');
$routes->post('update/(:num)', 'Home::update/$1');
//




$routes->get('dashboard', 'CampaignController::index');

$routes->get('camptable', 'CampaignController::showUser');
$routes->get('addcamp', 'CampaignController::addCamp');


$routes->post('store-camp', 'CampaignController::store');
$routes->get('campdel/(:num)', 'CampaignController::deleteCamp/$1');
$routes->post('cfilter', 'CampaignController::filter');

$routes->post('cupdate/(:num)', 'CampaignController::updateUser/$1');
//
// $routes->get('mongo/get','LoggerReportController::getMongo');
// $routes->get('mongo/report','LoggerReportController::getMongoHourly');

// // $routes->get('mysql/get','LoggerReportController::getMysql');
// $routes->get('mysql/report','LoggerReportController::getMysqlHourly');
// $routes->get('elastic/report','LoggerReportController::getElasticHourly');
$routes->get('dwn/(:any)','LoggerReportController::download/$1');
$routes->get('dwnh/(:any)','LoggerReportController::downloadHourly/$1');
$routes->get('report/(:any)','LoggerReportController::logger/$1');
$routes->get('hreport/(:any)','LoggerReportController::hourly/$1');

$routes->get('filter1/(:any)','LoggerReportController::filter/$1');
// $routes->match(['get', 'post'], 'filter1/(:any)', 'LoggerReportController::filter/$1');
$routes->get('chat', 'Home::chat');


