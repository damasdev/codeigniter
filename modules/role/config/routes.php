<?php

$route['role']['GET'] = 'Role/index';
$route['role']['POST'] = 'Role/store';
$route['role/datatables']['POST'] = 'Role/datatables';
$route['role/(:any)/edit']['GET'] = 'Role/edit/$1';
$route['role/(:any)']['GET'] = 'Role/show/$1';
$route['role/(:any)']['DELETE'] = 'Role/destroy/$1';
$route['role/(:any)']['POST'] = 'Role/update/$1';
