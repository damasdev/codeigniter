<?php defined('BASEPATH') or exit('No direct script access allowed');

class Login extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Login Page
     *
     * @return void
     */
    public function index()
    {
        $data['title'] = "Login";

        $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

        $data['email'] = [
            'name' => 'email',
            'id' => 'email',
            'class' => 'form-control',
            'placeholder' => 'Enter Email',
            'type' => 'text',
            'value' => $this->form_validation->set_value('email'),
        ];

        $data['password'] = [
            'name' => 'password',
            'id' => 'password',
            'class' => 'form-control',
            'placeholder' => 'Password',
            'type' => 'password',
        ];

        $this->render('login', $data);
    }

    /**
     * Store Authentication
     *
     * @return void
     */
    public function store()
    {
        try {
            $form = [
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'remember' => (bool) $this->input->post('remember'),
            ];

            $this->form_validation->set_data($form);

            if (!$this->form_validation->run('login')) {
                $errors = $this->form_validation->error_array();
                throw new Exception(current($errors));
            }

            $user = $this->auth_library->login($form['email'], $form['password']);

            if (!$user) {
                throw new Exception("Wrong Email or Password");
            }

            redirect('home', 'refresh');
            die();
        } catch (\Throwable $th) {
            $this->session->set_flashdata('message', $th->getMessage());

            redirect('auth/login');
            die();
        }
    }
}
