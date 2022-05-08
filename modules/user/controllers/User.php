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
	
	/**
	 * Store User
	 *
	 * @return mixed
	 */
	public function store():mixed
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

			$this->userModel->insert($data);

			return $this->jsonResponse([
				'status' => 'success',
				'message' => 'Data successfuly created'
			], 200);
		} catch (\Throwable $th) {
			return $this->jsonResponse([
				'status' => 'error',
				'message' => $th->getMessage()
			], 400);
		}
	}

	/**
	 * Destroy User
	 *
	 * @param  int $id
	 * @return mixed
	 */
	public function destroy(int $id): mixed
	{
		try {

			$user = $this->userModel->find($id);
			if (!$user) {
				throw new Exception("Data not found");
			}

			if ($user->is_root) {
				throw new Exception("Root can't be deleted!");
			}

			$this->userModel->delete($id);

			return $this->jsonResponse([
				'status' => 'success',
				'message' => 'Your data has been deleted.'
			], 200);
		} catch (\Throwable $th) {
			return $this->jsonResponse([
				'status' => 'error',
				'message' => $th->getMessage()
			], 400);
		}
	}
}
