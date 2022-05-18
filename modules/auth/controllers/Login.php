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

            return $this->jsonResponse([
                'status' => 'success',
                'message' => 'Login Successfuly'
            ], 200);
        } catch (\Throwable $th) {
            return $this->jsonResponse([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 400);
        }
    }
}
