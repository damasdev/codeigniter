<?php defined('BASEPATH') or exit('No direct script access allowed');

class Home extends MY_Controller
{
	public function index()
	{
		$data['title'] = 'Dashboard';

		$this->render('home', $data);
	}
}
