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

			$this->menuModel->insert($data);

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
	 * Destroy Menu
	 *
	 * @param  int $id
	 * @return mixed
	 */
	public function destroy(int $id): mixed
	{
		try {

			$this->menuModel->delete($id);

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
	 * Show Menu
	 *
	 * @param  int $id
	 * @return void
	 */
	public function show(int $id): void
	{
		$menu = $this->menuModel->find($id);

		if (!$menu) {
			show_404();
		}

		$data['title'] = 'Show Menu';
		$data['menu'] = $menu;

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
		$menu = $this->menuModel->find($id);

		if (!$menu) {
			show_404();
		}

		$data['title'] = 'Edit Menu';
		$data['menu'] = $menu;
		$data['parents'] = $this->menuModel->parent();

		$this->render('edit-menu', $data);
	}

	public function update(int $id)
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

			$this->menuModel->update($id, $data);

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
