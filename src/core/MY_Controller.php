<?php

class MY_Controller extends MX_Controller
{
    /**
     * privileges.
     *
     * @var array
     */
    private $privileges = [];

    /**
     * __construct.
     *
     * @return void
     */
    public function __construct()
    {
        $role = $this->session->user->role ?? null;
        $this->privileges = $this->config->item('privilege')[$role] ?? [];
    }

    /**
     * Assert Privilege.
     *
     * @param string $privilegeItem
     *
     * @return void
     */
    protected function assertPrivilege(string $privilegeItem): void
    {
        $hasPrivilegeAccess = in_array($privilegeItem, $this->privileges);
        if (!$hasPrivilegeAccess) {
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
     * Render view.
     *
     * @param string $view
     * @param array  $vars
     */
    protected function render($view, $vars = [])
    {
        return $this->twig->display($view, $vars);
    }

    /**
     * Return response with json format.
     *
     * @param mixed $payload
     * @param int   $statusCode
     *
     * @return void
     */
    protected function jsonResponse($payload, int $statusCode = 200): void
    {
        $this->output
            ->set_status_header($statusCode)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(
                json_encode(
                    $payload,
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK
                )
            )->_display();
        exit;
    }
}
