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
		$data['title'] = 'Menu';

		$data['menus'] = $this->menuModel->all();
		$data['parents'] = $this->menuModel->parent();

		$this->render('menu', $data);
	}

	public function store()
	{
		try {

			$data = [
				'name' => $this->input->post('name'),
				'parent' => $this->input->post('parent') ?? NULL,
				'icon' => $this->input->post('icon') ?? NULL,
				'slug' => $this->input->post('slug') ?? NULL,
				'number' => $this->input->post('number')
			];

			if (!$this->form_validation->run('menu')) {
				$errors = $this->form_validation->error_array();
				throw new Exception(current($errors));
			}

			if (!$this->menuModel->insert($data)) {
				throw new Exception("Something wrong");
			}

			redirect('menu');
			die();
		} catch (\Throwable $th) {
			$this->session->set_flashdata('message', $th->getMessage());

			redirect('menu', 'refresh');
			die();
		}
	}
}
