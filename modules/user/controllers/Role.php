<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Role extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('RoleModel', 'roleModel');
	}
	
	public function index()
	{
		$this->render('role');
	}
}
