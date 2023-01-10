<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Menu_model', 'menuModel');
	}

	/**
	 * Index
	 *
	 * @return void
	 */
	public function index(): void
	{
		$data['title'] = 'Menu';
		$data['parents'] = $this->menuModel->parent();

		$this->render('menu', $data);
	}

	/**
	 * Store Data
	 *
	 * @return void
	 */
	public function store(): void
	{
		$this->db->trans_start();
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

			$number = $this->menuModel->current($data['parent']);

			$data['number'] = $number++;

			$this->menuModel->insert($data);

			$this->db->trans_complete();

			$this->jsonResponse([
				'status' => 'success',
				'message' => 'Data successfuly created'
			], 200);
		} catch (\Throwable $th) {
			$this->db->trans_rollback();
			$this->jsonResponse([
				'status' => 'error',
				'message' => $th->getMessage()
			], 400);
		}
	}

	/**
	 * Destroy Menu
	 *
	 * @param  int $id
	 * @return void
	 */
	public function destroy(int $id): void
	{
		try {

			$this->menuModel->delete(['id' => $id]);

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
	 * Show Menu
	 *
	 * @param  int $id
	 * @return void
	 */
	public function show(int $id): void
	{
		$this->load->model('role/Role_model', 'roleModel');
		$menu = $this->menuModel->find(['id' => $id]);

		if (!$menu) {
			show_404();
		}

		$data['title'] = 'Show Menu';
		$data['menu'] = $menu;

		$data['roles'] = $this->roleModel->allWithMenu([
			'type' => 'user',
			'menu_id' => $id
		]);

		$this->render('show-menu', $data);
	}

	/**
	 * Edit Menu
	 *
	 * @param  int $id
	 * @return void
	 */
	public function edit(int $id): void
	{
		$menu = $this->menuModel->find(['id' => $id]);

		if (!$menu) {
			show_404();
		}

		$data['title'] = 'Edit Menu';
		$data['menu'] = $menu;
		$data['parents'] = $this->menuModel->parent();

		$this->render('edit-menu', $data);
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
				'parent' => $this->input->post('parent') ?? NULL,
				'icon' => $this->input->post('icon') ?? NULL,
				'slug' => $this->input->post('slug') ?? NULL,
				'number' => $this->input->post('number')
			];

			if (!$this->form_validation->run('menu')) {
				$errors = $this->form_validation->error_array();
				throw new Exception(current($errors));
			}

			$data['parent'] = $data['parent'] > 0 ? $data['parent'] : NULL;

			$this->menuModel->update($data, ['id' => $id]);

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

		$this->jsonResponse($this->datatables->table('menus')->draw());
	}
}
