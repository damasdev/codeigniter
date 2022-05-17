<?php

class User extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->jsonResponse([
			'status' => 'success',
			'message' => 'Data loaded successfully',
			'data' => []
		]);
	}

	public function store()
	{
		$this->jsonResponse([
			'status' => 'success',
			'message' => 'Data stored successfully',
			'data' => []
		]);
	}
}
