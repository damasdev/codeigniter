<?php

$route['feature']['GET'] = 'Feature/index';
$route['feature']['POST'] = 'Feature/store';
$route['feature/(:num)']['GET'] = 'Feature/show/$1';
$route['feature/(:num)']['DELETE'] = 'Feature/destroy/$1';
$route['feature/(:num)']['POST'] = 'Feature/update/$1';
$route['feature/(:num)/edit']['GET'] = 'Feature/edit/$1';
