<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['role']['GET'] = 'Role/index';
$route['role']['POST'] = 'Role/store';
$route['role/(:num)']['GET'] = 'Role/show/$1';
$route['role/(:num)']['DELETE'] = 'Role/destroy/$1';
$route['role/(:num)']['POST'] = 'Role/update/$1';
$route['role/(:num)/edit']['GET'] = 'Role/edit/$1';
