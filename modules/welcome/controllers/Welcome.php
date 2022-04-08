<?php defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends MY_Controller
{
	public function __construct()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		}
	}

	public function index()
	{
		$this->render('welcome');
	}
}
