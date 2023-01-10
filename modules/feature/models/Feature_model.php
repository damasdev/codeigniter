<?php

class Feature_model extends MY_Model
{
	public $table = "features";

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
