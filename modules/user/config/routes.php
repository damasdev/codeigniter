<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['user']['GET'] = 'User/index';
$route['user']['POST'] = 'User/store';
$route['user/(:num)']['DELETE'] = 'User/destroy/$1';
