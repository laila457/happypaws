<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Auth routes
$route['auth'] = 'auth/index';
$route['auth/login'] = 'auth/login';
$route['auth/register'] = 'auth/register';
$route['auth/logout'] = 'auth/logout';

// Dashboard routes
$route['dashboard'] = 'dashboard/index';
$route['dashboard/payment/(:num)'] = 'dashboard/payment/$1';
// Admin routes
$route['admin/dashboard'] = 'admin/dashboard/index';
