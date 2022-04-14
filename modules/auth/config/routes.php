<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['auth'] = 'Auth/index';
$route['auth/logout']['GET'] = 'Logout/index';
$route['auth/login']['GET'] = 'Login/index';
$route['auth/login']['POST'] = 'Login/store';
$route['auth/register']['GET'] = 'Register/index';
$route['auth/register']['POST'] = 'Register/store';
