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
            'rules' => 'required|trim|is_unique[roles.code]|alpha_dash'
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
