<?php

$config['menu'] = [
    [
        'id'         => 'dashboard',
        'parent'     => null,
        'title'      => 'Dashboard',
        'icon'       => 'ti ti-dashboard',
        'slug'       => 'home',
        'privileges' => [PRIVILEGE_ROOT, PRIVILEGE_USER],
    ],
    [
        'id'         => 'setting',
        'parent'     => null,
        'title'      => 'Settings',
        'icon'       => 'ti ti-adjustments',
        'slug'       => null,
        'privileges' => [PRIVILEGE_ROOT],
    ],
    [
        'id'         => 'user',
        'parent'     => 'setting',
        'title'      => 'User',
        'icon'       => null,
        'slug'       => 'user',
        'privileges' => [PRIVILEGE_ROOT],
    ],
    [
        'id'         => 'role',
        'parent'     => 'setting',
        'title'      => 'Role',
        'icon'       => null,
        'slug'       => 'role',
        'privileges' => [PRIVILEGE_ROOT],
    ],
];
