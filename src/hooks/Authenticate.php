<?php

class Authenticate extends MY_Controller
{
    private $whitelist = [];
    private $permissions = [];

    public function __construct()
    {
        $this->whitelist = $this->config->item('whitelist');
        $this->permissions = $this->config->item('permissions');
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
                    'message' => 'Unauthorized',
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

        // Check Basic Feature
        if (in_array($method, $this->permissions[$module][$class] ?? [])) {
            return;
        }

        // Check User Permission
        if (!$this->hasPermission($module, $class, $method)) {
            if ($this->input->is_ajax_request()) {
                $this->jsonResponse([
                    'status'  => 'error',
                    'message' => 'You dont have permission',
                ], 401);
            } else {
                show_error('You dont have permission', 401);
            }
        }
    }

    /**
     * Check Permission.
     *
     * @param string $class
     * @param string $method
     *
     * @return bool
     */
    private function hasPermission(string $module, string $class, string $method): bool
    {
        // User Data
        $user = $this->auth_library->user();

        // Super Administrator
        if ($user->type === 'admin') {
            return true;
        }

        // Load Features
        $features = $this->auth_library->features($user->role_id) ?? [];
        foreach ($features as $feature) {
            // Check Permission
            if (isEqual($module, (string) $feature->module) && isEqual($class, (string) $feature->class) && isEqual($method, (string) $feature->method)) {
                return true;
            }
        }

        return false;
    }

    /**
     * isApiRequest.
     *
     * @return bool
     */
    private function isApiRequest(): bool
    {
        return $this->uri->segment(1) === 'api';
    }
}
