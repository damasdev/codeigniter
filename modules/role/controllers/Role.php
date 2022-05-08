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

		$data['title'] = 'Role';
		$data['roles'] = $roles;

		$this->render('role', $data);
	}

	/**
	 * Store Role
	 *
	 * @return mixed
	 */
	public function store(): mixed
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

			$this->roleModel->insert($data);

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
	 * Destroy Role
	 *
	 * @param  int $id
	 * @return mixed
	 */
	public function destroy(int $id): mixed
	{
		try {

			$role = $this->roleModel->find($id);
			if (!$role) {
				throw new Exception("Data not found");
			}

			if ($role->is_root) {
				throw new Exception("Root can't be deleted!");
			}

			$this->roleModel->delete($id);

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

	/**
	 * Show Role
	 *
	 * @param  int $id
	 * @return void
	 */
	public function show(int $id): void
	{
		$role = $this->roleModel->find($id);

		if (!$role) {
			show_404();
		}

		$data['title'] = 'Show Role';
		$data['role'] = $role;

		$this->render('show-role', $data);
	}

	/**
	 * Edit Role
	 *
	 * @param  int $id
	 * @return void
	 */
	public function edit(int $id): void
	{
		$role = $this->roleModel->find($id);

		if (!$role) {
			show_404();
		}

		$data['title'] = 'Edit Role';
		$data['role'] = $role;

		$this->render('edit-role', $data);
	}

	public function update(int $id)
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

			$this->roleModel->update($id, $data);

			return $this->jsonResponse([
				'status' => 'success',
				'message' => 'Data successfuly updated'
			], 200);
		} catch (\Throwable $th) {
			return $this->jsonResponse([
				'status' => 'error',
				'message' => $th->getMessage()
			], 400);
		}
	}
}
