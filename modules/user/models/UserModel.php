<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class UserModel extends MY_Model
{
	public $table = "users";

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Find User With Role
	 *
	 * @param  array $conditions
	 * @return ?stdClass
	 */
	public function findWithRole(array $conditions = []): ?stdClass
	{
		$this->db->select([
			'users.id', 'users.name', 'users.email', 'users.password', 'users.role_id', 'roles.name as role', 'roles.type'
		])->join('roles', 'roles.id = users.role_id');

		return $this->find($conditions);
	}
}
