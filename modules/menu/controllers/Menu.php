<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('MenuModel', 'menuModel');
	}
	
	public function index()
	{
		$this->render('menu');
	}
}
