<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class FeatureModel extends MY_Model
{
	public $table = "features";

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get All Feature
	 *
	 * @param  int $role_id
	 * @return array
	 */
	public function role(int $role_id): array
	{
		$this->db->select([
			'features.id',
			'features.module',
			'features.class',
			'features.method',
		]);

		$this->db->join('features_acl', 'features.id = features_acl.feature_id');

		return $this->db->where('features_acl.role_id', $role_id)->get($this->table)->result();
	}
}
