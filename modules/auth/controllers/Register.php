<?php defined('BASEPATH') or exit('No direct script access allowed');

class Register extends MY_Controller
{
    private $data = [];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Register Page
     *
     * @return void
     */
    public function index()
    {
        $this->data['title'] = $this->lang->line('create_user_heading');
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        $this->data['first_name'] = [
            'name' => 'first_name',
            'id' => 'first_name',
            'class' => 'form-control',
            'type' => 'text',
            'value' => $this->form_validation->set_value('first_name'),
        ];

        $this->data['last_name'] = [
            'name' => 'last_name',
            'id' => 'last_name',
            'class' => 'form-control',
            'type' => 'text',
            'value' => $this->form_validation->set_value('last_name'),
        ];

        $this->data['identity'] = [
            'name' => 'identity',
            'id' => 'identity',
            'class' => 'form-control',
            'type' => 'text',
            'value' => $this->form_validation->set_value('identity'),
        ];

        $this->data['email'] = [
            'name' => 'email',
            'id' => 'email',
            'class' => 'form-control',
            'type' => 'text',
            'value' => $this->form_validation->set_value('email'),
        ];

        $this->data['company'] = [
            'name' => 'company',
            'id' => 'company',
            'class' => 'form-control',
            'type' => 'text',
            'value' => $this->form_validation->set_value('company'),
        ];

        $this->data['phone'] = [
            'name' => 'phone',
            'id' => 'phone',
            'class' => 'form-control',
            'type' => 'text',
            'value' => $this->form_validation->set_value('phone'),
        ];

        $this->data['password'] = [
            'name' => 'password',
            'id' => 'password',
            'class' => 'form-control',
            'type' => 'password',
            'value' => $this->form_validation->set_value('password'),
        ];

        $this->data['password_confirm'] = [
            'name' => 'password_confirm',
            'id' => 'password_confirm',
            'class' => 'form-control',
            'type' => 'password',
            'value' => $this->form_validation->set_value('password_confirm'),
        ];

        $this->render('register', $this->data);
    }

    public function store()
    {
        $this->data['title'] = $this->lang->line('login_heading');

        try {
            $form = [
                'identity' => $this->input->post('identity'),
                'password' => $this->input->post('password'),
                'remember' => (bool) $this->input->post('remember'),
            ];

            $this->form_validation->set_data($form);

            if (!$this->form_validation->run('register')) {
                $errors = $this->form_validation->error_array();
                throw new Exception(current($errors));
            }

            $email = strtolower($this->input->post('email'));
            $identity = $this->input->post('identity');
            $password = $this->input->post('password');

            $additional_data = [
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'company' => $this->input->post('company'),
                'phone' => $this->input->post('phone'),
            ];

            if (!$this->ion_auth->register($identity, $password, $email, $additional_data)) {
                throw new Exception($this->ion_auth->errors());
            }

            $this->session->set_flashdata('message', $this->ion_auth->messages());

            redirect('auth/check', 'refresh');
            die();
        } catch (\Throwable $th) {
            $this->session->set_flashdata('message', $th->getMessage());

            redirect('auth/login');
            die();
        }
    }
}
