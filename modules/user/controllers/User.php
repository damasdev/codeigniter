<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('UserModel', 'userModel');
	}

	public function index()
	{
		$this->load->model('role/RoleModel', 'roleModel');

		$data['title'] = "User";
		$data['users'] = $this->userModel->all();
		$data['roles'] = $this->roleModel->role();

		$this->render('user', $data);
	}

	public function store()
	{
		try {

			$data = [
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'password' => $this->input->post('password'),
				'role_id' => $this->input->post('role_id'),
			];

			if (!$this->form_validation->run('user')) {
				$errors = $this->form_validation->error_array();
				throw new Exception(current($errors));
			}

			// Run Password Hash
			$data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

			if (!$this->userModel->insert($data)) {
				throw new Exception("Something wrong");
			}

			redirect('user');
			die();
		} catch (\Throwable $th) {
			$this->session->set_flashdata('message', $th->getMessage());

			redirect('user', 'refresh');
			die();
		}
	}
}
