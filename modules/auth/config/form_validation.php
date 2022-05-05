<?php

$config = [
    'login' => [
        [
            'field' => 'email',
            'label' => 'email',
            'rules' => 'required'
        ],
        [
            'field' => 'password',
            'label' => 'password',
            'rules' => 'required'
        ],
    ],
    'register' => [
        [
            'field' => 'first_name',
            'label' => 'first_name',
            'rules' => 'trim|required'
        ],
        [
            'field' => 'last_name',
            'label' => 'last_name',
            'rules' => 'trim|required'
        ],
        [
            'field' => 'email',
            'label' => 'email',
            'rules' => 'trim|required|valid_email|is_unique[users.email]'
        ],
        [
            'field' => 'phone',
            'label' => 'phone',
            'rules' => 'trim'
        ],
        [
            'field' => 'company',
            'label' => 'company',
            'rules' => 'trim'
        ],
        [
            'field' => 'password',
            'label' => 'password',
            'rules' => 'required|min_length[6]|matches[password_confirm]'
        ],
        [
            'field' => 'password_confirm',
            'label' => 'password_confirm',
            'rules' => 'required'
        ],
    ]
];