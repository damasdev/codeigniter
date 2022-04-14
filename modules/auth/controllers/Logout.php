<?php defined('BASEPATH') or exit('No direct script access allowed');

class Logout extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Redirect to Login Page
     *
     * @return void
     */
    public function index()
    {
        // Do Logout
        $this->ion_auth->logout();

        redirect('auth/login', 'refresh');
        die();
    }
}
