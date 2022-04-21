<?php

class Authenticate extends MY_Controller
{
    private $data = [];

    public function __construct()
    {
        $this->data = $this->config->item('modules');
    }

    public function init()
    {
        $module = $this->router->fetch_module();
        $class = $this->router->fetch_class();
        $method = $this->router->fetch_method();

        if (in_array($method, $this->data[$module][$class] ?? [])) {
            return;
        }

        if (!$this->session->has_userdata('user_id')) {
            redirect('auth/login', 'refresh');
            die();
        }
    }
}
