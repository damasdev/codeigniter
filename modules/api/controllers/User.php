<?php

class User extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->jsonResponse('index');
	}

	public function store()
	{
		$this->jsonResponse('store');
	}
}
