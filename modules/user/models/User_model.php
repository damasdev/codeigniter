<?php

class User_model extends MY_Model
{
	public $table = "users";

	/**
	 * Find User With Role
	 *
	 * @param  array $conditions
	 * @return ?stdClass
	 */
	public function findWithRole(array $conditions = []): ?stdClass
	{
		$this->db->select([
			'users.id', 'users.name', 'users.email', 'users.password', 'users.role'
		]);

		return $this->find($conditions);
	}
}
