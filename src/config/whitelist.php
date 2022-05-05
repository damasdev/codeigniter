<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Auth Modules
$config['modules']['auth']['LoginController'] = ['index', 'store'];
$config['modules']['auth']['AuthController'] = ['logout'];

// Matches CLI
$config['modules']['']['matches'] = [
    'index', 'help',
    'create:app', 'create:model', 'create:view', 'create:controller', 'create:migration',
    'undo:migration', 'do:migration', 'reset:migration'
];
