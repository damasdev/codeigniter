<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['auth'] = 'Auth/index';
$route['auth/logout']['GET'] = 'Auth/logout';
$route['auth/login']['GET'] = 'Login/index';
$route['auth/login']['POST'] = 'Login/store';
