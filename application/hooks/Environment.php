<?php

class Environment
{
    public function init()
    {
        $dotenv = Dotenv\Dotenv::createUnsafeMutable(FCPATH . "../");
        $dotenv->load();

        $dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS']);
    }
}
