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
            'rules' => 'trim|required|valid_email|is_unique[users.email]'
        ],
        [
            'field' => 'password',
            'label' => 'password',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'role',
            'label' => 'role',
            'rules' => 'required|trim'
        ],
    ]
];
