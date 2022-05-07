<?php

$config = [
    'user' => [
        [
            'field' => 'name',
            'label' => 'name',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'email',
            'label' => 'email',
            'rules' => 'required|valid_email'
        ],
        [
            'field' => 'password',
            'label' => 'password',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'role_id',
            'label' => 'role_id',
            'rules' => 'required|trim'
        ],
    ]
];
