<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('MenuAclModel', 'menuAclModel');
	}

	public function store()
	{
		try {

			$data = [
				'is_active' => $this->input->post('is_active')
			];

			$conditions = [
				'role_id' => $this->input->post('role_id'),
				'menu_id' => $this->input->post('menu_id')
			];

			$menu = $this->menuAclModel->find($conditions);

			if ($menu) {
				$this->menuAclModel->update($data, $conditions);
			} else {
				$this->menuAclModel->insert(array_merge($data, $conditions));
			}

			$this->jsonResponse([
				'status' => 'success',
				'message' => 'Permission updated successfully'
			], 200);
		} catch (\Throwable $th) {
			$this->jsonResponse([
				'status' => 'success',
				'message' => $th->getMessage()
			], 400);
		}
	}
}
