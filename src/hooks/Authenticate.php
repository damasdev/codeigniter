<?php

class Authenticate extends MY_Controller
{
    private $whitelist = [];

    public function __construct()
    {
        $this->whitelist = $this->config->item('whitelist');
        $this->hmvc();
    }

    /**
     * HMVC : fix callback form_validation
     * https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc.
     *
     * @return void
     */
    private function hmvc()
    {
        $this->load->library('form_validation');
        $this->form_validation->CI = &$this;
    }

    public function init()
    {
        // Init Data
        $module = strtolower($this->router->fetch_module() ?? '');
        $class = strtolower($this->router->fetch_class());
        $method = strtolower($this->router->fetch_method());

        // Validate API
        if ($this->isApiRequest()) {
            if (!$this->jwt_library->validate()) {
                $this->jsonResponse([
                    'status' => 'error',
                    'message' => 'Unauthorized'
                ], 401);
            }

            return;
        }

        // Check Whitelist
        if (in_array($method, $this->whitelist[$module][$class] ?? [])) {
            return;
        }

        // Check Login Status
        if (!$this->auth_library->isLoggedIn()) {
            redirect('auth/login', 'refresh');
            exit();
        }
    }

    /**
     * isApiRequest.
     *
     * @return bool
     */
    private function isApiRequest(): bool
    {
        $this->setAPI(true);

        return $this->uri->segment(1) === 'api';
    }
}
