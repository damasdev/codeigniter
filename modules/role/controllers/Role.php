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
		$roles = $this->roleModel->all();

		$this->render('role', [
			'roles' => $roles
		]);
	}

	public function store()
	{
		try {

			$data = [
				'name' => $this->input->post('name'),
				'description' => $this->input->post('description'),
			];

			if (!$this->form_validation->run('role')) {
				$errors = $this->form_validation->error_array();
				throw new Exception(current($errors));
			}

			if (!$this->roleModel->insert($data)) {
				throw new Exception("Something wrong");
			}

			redirect('role');
			die();
		} catch (\Throwable $th) {
			$this->session->set_flashdata('message', $th->getMessage());

			redirect('role', 'refresh');
			die();
		}
	}
}
