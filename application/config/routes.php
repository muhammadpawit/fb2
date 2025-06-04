<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'login';
// $route['default_controller'] = 'auth/login';
// $route['auth/callback'] = 'auth/callback';
// $route['auth/logout'] = 'auth/logout';
$route['404_override'] = 'Dash/notfound';
$route['Ajuanalatalat/(:num)'] = 'Ajuanalatalat/index/$1';
$route['translate_uri_dashes'] = FALSE;
