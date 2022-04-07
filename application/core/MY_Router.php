<?php

/* load the MX_Router class */
require APPPATH.'third_party/MX/Router.php';

class MY_Router extends MX_Router
{
    public function set_class($class)
    {
        // fixing Severity: 8192
        // Message: strpos(): Non-string needles will be interpreted as strings in the future. 
        // Use an explicit chr() call to preserve the current behavior
        $suffix = $this->config->item('controller_suffix');
        if (isset($suffix) && strpos($class, $suffix) === FALSE) {
            $class .= $suffix;
        }

        CI_Router::set_class($class);
    }
}
