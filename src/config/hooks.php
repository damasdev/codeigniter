<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/userguide3/general/hooks.html
|
*/

$hook['pre_system'][] = array(
    'class' => 'Environment',
    'function' => 'init',
    'filename' => 'Environment.php',
    'filepath' => 'hooks'
);

$hook['pre_controller'][] = array(
    'class' => 'Authenticate',
    'function' => 'init',
    'filename' => 'Authenticate.php',
    'filepath' => 'hooks'
);

$hook['display_override'][] = array(
    'class' => 'Develbar',
    'function' => 'debug',
    'filename' => 'Develbar.php',
    'filepath' => 'third_party/DevelBar/hooks'
);
