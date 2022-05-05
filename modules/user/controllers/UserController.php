<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class UserController extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('UserModel', 'userModel');
	}
	
	public function index()
	{
		$this->render('user');
	}
}
