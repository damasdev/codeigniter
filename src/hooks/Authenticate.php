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
        // Init Data
        $module = $this->router->fetch_module() ?? '';
        $class = $this->router->fetch_class();
        $method = $this->router->fetch_method();

        // Validate API
        if ($this->isApiRequest()) {

            if (!$this->jwt_library->validate()) {
                return $this->jsonResponse([
                    'message' => 'Unauthorized'
                ], 401);
            }

            return;
        }

        // Check Whitelist
        if (in_array($method, $this->data[$module][$class] ?? [])) {
            return;
        }

        // Check Login Status
        if (!$this->auth_library->isLoggedIn()) {
            redirect('auth/login', 'refresh');
            die();
        }

        // Check User Permission
        if (!$this->hasPermission($module, $class, $method)) {
            show_error('You dont have permission', 401);
        }
    }

    /**
     * Check Permission
     * 
     * @param string $class
     * @param string $method
     * @return boolean
     */
    private function hasPermission(string $module, string $class, string $method): bool
    {
        // User Data
        $user = $this->auth_library->user();

        // Super Administrator
        if ($user->is_root) {
            return TRUE;
        }

        // Load Features
        $features = $this->auth_library->features($user->role_id) ?? [];
        foreach ($features as $feature) {
            // Check Permission
            if (isEqual($module, (string) $feature->module) && isEqual($class, (string) $feature->class) && isEqual($method, (string) $feature->method)) {
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * isApiRequest
     *
     * @return bool
     */
    private function isApiRequest(): bool
    {
        return $this->uri->segment(1) === 'api';
    }
}
