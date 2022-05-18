<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Feature extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('FeatureModel', 'featureModel');
	}

	public function index()
	{
		$data['title'] = 'Feature';

		$this->render('feature', $data);
	}

	/**
	 * Store Feature
	 *
	 * @return mixed
	 */
	public function store(): mixed
	{
		try {

			$data = [
				'module' => $this->input->post('module'),
				'class' => $this->input->post('class'),
				'method' => $this->input->post('method'),
				'description' => $this->input->post('description'),
			];

			if (!$this->form_validation->run('feature')) {
				$errors = $this->form_validation->error_array();
				throw new Exception(current($errors));
			}

			$this->featureModel->insert($data);

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
	 * Destroy Feature
	 *
	 * @param  int $id
	 * @return mixed
	 */
	public function destroy(int $id): mixed
	{
		try {

			$feature = $this->featureModel->find(['id' => $id]);
			if (!$feature) {
				throw new Exception("Data not found");
			}

			$this->featureModel->delete(['id' => $id]);

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
	 * Show Feature
	 *
	 * @param  int $id
	 * @return void
	 */
	public function show(int $id): void
	{
		$feature = $this->featureModel->find(['id' => $id]);

		if (!$feature) {
			show_404();
		}

		$data['title'] = 'Show Feature';
		$data['feature'] = $feature;

		$this->render('show-feature', $data);
	}

	/**
	 * Edit Feature
	 *
	 * @param  int $id
	 * @return void
	 */
	public function edit(int $id): void
	{
		$feature = $this->featureModel->find(['id' => $id]);

		if (!$feature) {
			show_404();
		}

		$data['title'] = 'Edit Feature';
		$data['feature'] = $feature;

		$this->render('edit-feature', $data);
	}

	public function update(int $id)
	{
		try {

			$data = [
				'module' => $this->input->post('module'),
				'class' => $this->input->post('class'),
				'method' => $this->input->post('method'),
				'description' => $this->input->post('description'),
			];

			if (!$this->form_validation->run('feature')) {
				$errors = $this->form_validation->error_array();
				throw new Exception(current($errors));
			}

			$this->featureModel->update($data, ['id' => $id]);

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

	public function datatables()
	{
		$this->load->library('datatables');

		$this->jsonResponse($this->datatables->table('features')->draw());
	}
}
