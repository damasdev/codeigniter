<?php defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Redirect to Dashboard
	 *
	 * @return void
	 */
	public function index()
	{
		redirect('/home', 'refresh', 301);
		die();
	}

	public function logout()
	{
		$this->auth_library->logout();
		redirect('/auth/login', 'refresh');
		die();
	}
}
