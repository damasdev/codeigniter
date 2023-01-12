<?php

$config = [
    'store_role' => [
        [
            'field' => 'name',
            'label' => 'name',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'code',
            'label' => 'code',
            'rules' => 'required|trim|is_unique[roles.code]|alpha'
        ],
    ],
    'update_role' => [
        [
            'field' => 'name',
            'label' => 'name',
            'rules' => 'required|trim'
        ]
    ]
];
