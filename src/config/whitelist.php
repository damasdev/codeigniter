<?php

/**
 * Whitelist.
 *
 * User can access feature without login
 */

// Auth Modules
$config['whitelist']['auth']['login'] = ['index', 'store'];
$config['whitelist']['auth']['auth'] = ['logout'];

// Matches CLI
$config['whitelist']['']['matches'] = [
    'index', 'help',
    'create:app', 'create:model', 'create:view', 'create:controller', 'create:migration',
    'undo:migration', 'do:migration', 'reset:migration',
];

/**
 * Basic Feature.
 *
 * User can access feature without permission
 */
$config['permissions']['auth']['auth'] = ['index'];
$config['permissions']['home']['home'] = ['index'];
