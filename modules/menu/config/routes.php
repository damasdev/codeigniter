<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['menu']['GET'] = 'Menu/index';
$route['menu']['POST'] = 'Menu/store';
$route['menu/(:num)']['DELETE'] = 'Menu/destroy/$1';
