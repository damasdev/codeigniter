<?php

class Home extends MY_Controller
{
	public function index()
	{
		$data['title'] = 'Dashboard';

		$this->render('home', $data);
	}
}
