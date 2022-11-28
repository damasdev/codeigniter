<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class FeatureModel extends MY_Model
{
	public $table = "features";

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * All Feature With Alc
	 *
	 * @param  array $conditions
	 * @return ?array
	 */
	public function allWithAcl(array $conditions = []): ?array
	{
		$this->db->select([
			'features.id', 'features.class', 'features.method', 'features.module'
		])->join('features_acl', 'features_acl.feature_id = features.id');

		return $this->all($conditions);
	}
}
