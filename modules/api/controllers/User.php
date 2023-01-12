<?php

class User extends MY_Controller
{
    /**
     * Index
     *
     * @return void
     */
    public function index(): void
    {
        $this->jsonResponse([
            'status' => 'success',
            'message' => 'Data received successfully',
            'data' => []
        ]);
    }

    /**
     * Store Data
     *
     * @return void
     */
    public function store(): void
    {
        $this->jsonResponse([
            'status' => 'success',
            'message' => 'Data stored successfully',
            'data' => []
        ]);
    }
}
