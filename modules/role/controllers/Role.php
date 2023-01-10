<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Role extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Role_model', 'roleModel');
	}

	/**
	 * Index
	 *
	 * @return void
	 */
	public function index(): void
	{
		$data['title'] = 'Role';

		$this->render('role', $data);
	}

	/**
	 * Store Role
	 *
	 * @return void
	 */
	public function store(): void
	{
		try {

			$data = [
				'name' => $this->input->post('name'),
				'code' => $this->input->post('code')
			];

			if (!$this->form_validation->run('role')) {
				$errors = $this->form_validation->error_array();
				throw new Exception(current($errors));
			}

			$this->roleModel->insert($data);

			$this->jsonResponse([
				'status' => 'success',
				'message' => 'Data successfuly created'
			], 200);
		} catch (\Throwable $th) {
			$this->jsonResponse([
				'status' => 'error',
				'message' => $th->getMessage()
			], 400);
		}
	}

	/**
	 * Destroy Role
	 *
	 * @param  int $id
	 * @return void
	 */
	public function destroy(int $id): void
	{
		try {

			$role = $this->roleModel->find(['id' => $id]);
			if (!$role) {
				throw new Exception("Data not found");
			}

			if ($role->type === 'admin') {
				throw new Exception("Role can't be deleted!");
			}

			$this->roleModel->delete(['id' => $id]);

			$this->jsonResponse([
				'status' => 'success',
				'message' => 'Your data has been deleted.'
			], 200);
		} catch (\Throwable $th) {
			$this->jsonResponse([
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
		$role = $this->roleModel->find(['id' => $id]);

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
		$role = $this->roleModel->find(['id' => $id]);

		if (!$role) {
			show_404();
		}

		$data['title'] = 'Edit Role';
		$data['role'] = $role;

		$this->render('edit-role', $data);
	}

	/**
	 * Update Data
	 *
	 * @param  int $id
	 * @return void
	 */
	public function update(int $id): void
	{
		try {

			$data = [
				'name' => $this->input->post('name'),
				'code' => $this->input->post('code')
			];

			if (!$this->form_validation->run('role')) {
				$errors = $this->form_validation->error_array();
				throw new Exception(current($errors));
			}

			$this->roleModel->update($data, [
				'id' => $id
			]);

			$this->jsonResponse([
				'status' => 'success',
				'message' => 'Data successfuly updated'
			], 200);
		} catch (\Throwable $th) {
			$this->jsonResponse([
				'status' => 'error',
				'message' => $th->getMessage()
			], 400);
		}
	}

	/**
	 * Datatables
	 *
	 * @return void
	 */
	public function datatables(): void
	{
		$this->load->library('datatables');
		$data = $this->datatables->table('roles')->where('type', 'user')->draw();

		$this->jsonResponse($data);
	}
}
