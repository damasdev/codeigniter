<?php

/* load the MX_Controller class */
require_once APPPATH . 'third_party/MX/Controller.php';

class MY_Controller extends MX_Controller
{
    /**
     * Initialize Menu
     *
     * @return string
     */
    private function initializeMenu()
    {
        return $this->menu_library->render();
    }

    /**
     * Render view
     *
     * @param  string $view
     * @param  array $vars
     */
    protected function render($view, $vars = [])
    {
        // Initialize menu configuration
        $vars['sidebar'] = $this->initializeMenu();

        return $this->twig->display($view, $vars);
    }

    /**
     * Return response with json format
     *
     * @param mixed $payload
     * @param int $statusCode
     */
    protected function jsonResponse($payload, int $statusCode = 200)
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
