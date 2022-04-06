<?php

class Environment
{
    public function init()
    {
        $dotenv = Dotenv\Dotenv::createUnsafeMutable(FCPATH . "../");
        $dotenv->load();
    }
}
