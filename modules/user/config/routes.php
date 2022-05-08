<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['user']['GET'] = 'User/index';
$route['user']['POST'] = 'User/store';
$route['user/(:num)']['GET'] = 'User/show/$1';
$route['user/(:num)']['DELETE'] = 'User/destroy/$1';
$route['user/(:num)']['POST'] = 'User/update/$1';
$route['user/(:num)/edit']['GET'] = 'User/edit/$1';
