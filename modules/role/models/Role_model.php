<?php

class Role_model extends MY_Model
{
	public $table = "roles";


	/**
	 * All Role With Feature
	 *
	 * @param  array $conditions
	 * @return ?array
	 */
	public function allWithFeature(array $conditions = []): ?array
	{
		$this->db->select([
			'roles.id', 'roles.name', 'roles.code', 'features_acl.feature_id', 'features_acl.is_active'
		])->join('features_acl', 'features_acl.role_id = roles.id', 'LEFT');

		return $this->all($conditions);
	}

	/**
	 * All Role With Menu
	 *
	 * @param  array $conditions
	 * @return ?array
	 */
	public function allWithMenu(array $conditions = []): ?array
	{
		$this->db->select([
			'roles.id', 'roles.name', 'roles.code', 'menus_acl.menu_id', 'menus_acl.is_active'
		])->join('menus_acl', 'menus_acl.role_id = roles.id', 'LEFT');

		return $this->all($conditions);
	}
}
