<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['api/user']['GET'] = 'User/index';
$route['api/user']['POST'] = 'User/store';