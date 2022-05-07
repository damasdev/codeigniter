<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class UserModel extends CI_Model
{
	const TABLE_NAME = "users";

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Insert Data
	 *
	 * @param  mixed $data
	 * @return void
	 */
	public function insert(array $data): void
	{
		$this->db->insert(self::TABLE_NAME, $data);
	}

	/**
	 * Get All User
	 *
	 * @return array
	 */
	public function all(): array
	{
		$this->db->select([
			'users.id', 'users.name', 'users.email', 'roles.name as role'
		])->join('roles', 'roles.id = users.role_id');

		return $this->db->get(self::TABLE_NAME)->result_array();
	}
}
