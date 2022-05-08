<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['menu']['GET'] = 'Menu/index';
$route['menu']['POST'] = 'Menu/store';
$route['menu/(:num)']['GET'] = 'Menu/show/$1';
$route['menu/(:num)']['DELETE'] = 'Menu/destroy/$1';
$route['menu/(:num)']['POST'] = 'Menu/update/$1';
$route['menu/(:num)/edit']['GET'] = 'Menu/edit/$1';
