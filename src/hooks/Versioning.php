<?php

class Versioning extends MY_Controller
{
    private $versions = [];

    public function init()
    {
        $jsVersions = $this->config->item('v_js') ?? [];
        foreach ($jsVersions as $key => $value) {
            $this->setVersioning('js', $key, $value);
        }

        $this->twig->addGlobal('ver', $this->versions);
    }

    private function setVersioning(string $category, string $name, $version)
    {
        $this->versions[$category][$name] = "?v=$version";
    }
}
