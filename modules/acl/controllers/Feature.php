<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Feature extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('FeatureAclModel', 'featureAclModel');
	}

	public function store()
	{
		try {

			$data = [
				'is_active' => $this->input->post('is_active')
			];

			$conditions = [
				'role_id' => $this->input->post('role_id'),
				'feature_id' => $this->input->post('feature_id')
			];

			$feature = $this->featureAclModel->find($conditions);

			if ($feature) {
				$this->featureAclModel->update($data, $conditions);
			} else {
				$this->featureAclModel->insert(array_merge($data, $conditions));
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
