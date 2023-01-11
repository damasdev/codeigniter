<?php

class Auth extends MY_Controller
{
	/**
	 * Redirect to Dashboard
	 *
	 * @return void
	 */
	public function index(): void
	{
		redirect('/home', 'refresh', 301);
		die();
	}
	
	/**
	 * Logout
	 *
	 * @return void
	 */
	public function logout(): void
	{
		$this->auth_library->logout();
		redirect('/auth/login', 'refresh');
		die();
	}
}
