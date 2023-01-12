<?php

class MY_Controller extends MX_Controller
{
    /**
     * isAPI
     *
     * @var bool
     */
    private $isAPI = false;

    /**
     * setAPI
     *
     * @param  bool $isAPI
     * @return void
     */
    protected function setAPI(bool $isAPI): void
    {
        $this->isAPI = $isAPI;
    }

    /**
     * Assert Privilege.
     *
     * @return void
     */
    protected function assertPrivilege(string $privilegeItem): void
    {
        $privileges = $this->config->item('privilege')[user()->role ?? null] ?? [];

        $hasPrivilegeAccess = in_array($privilegeItem, $privileges);
        if (!$hasPrivilegeAccess) {
            if ($this->input->is_ajax_request() || $this->isAPI) {
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
     *
     * @return void
     */
    protected function render($view, $vars = []): void
    {
        if ($this->isAPI) {
            $this->jsonResponse($vars);
        }

        $this->twig->display($view, $vars);
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
