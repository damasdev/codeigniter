<?php

$config['menus'] = [
    [
        "id" => "dashboard",
        "parent" => null,
        "title" => "Dashboard",
        "icon" => "ti ti-dashboard",
        "slug" => "home",
    ],
    [
        "id" => "setting",
        "parent" => null,
        "title" => "Settings",
        "icon" => "ti ti-adjustments",
        "slug" => null,
    ],
    [
        "id" => "user",
        "parent" => "setting",
        "title" => "User",
        "icon" => null,
        "slug" => "user",
    ],
];
