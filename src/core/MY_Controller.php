<?php

/* load the MX_Controller class */
require APPPATH . 'third_party/MX/Controller.php';

class MY_Controller extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->hmvc();
    }

    /**
     * initializeMenu
     *
     * @return string
     */
    private function initializeMenu()
    {
        $items = $this->menuModel->all();
        $this->custom_menu->set_items($items);

        return $this->custom_menu->render();
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

    /**
     * Render view
     *
     * @param  string $view
     * @param  array $vars
     */
    protected function render($view, $vars = [])
    {
        // Initialize menu configuration
        $vars['menu'] = $this->initializeMenu();

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
            ->set_output(json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();
        exit;
    }
}
