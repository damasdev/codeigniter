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
	 * @param  array $data
	 * @return void
	 */
	public function insert(array $data): void
	{
		$this->db->insert(self::TABLE_NAME, $data);
	}

	/**
	 * Update Data
	 *
	 * @param  int $id
	 * @param  array $data
	 * @return void
	 */
	public function update(int $id, array $data): void
	{
		$this->db->where('id', $id)->update(self::TABLE_NAME, $data);
	}

	/**
	 * Find User By ID
	 *
	 * @param  int $id
	 * @return ?stdClass
	 */
	public function find(int $id): ?stdClass
	{
		$this->db->select([
			'users.id', 'users.name', 'users.email', 'users.role_id', 'roles.name as role', 'roles.type'
		])->join('roles', 'roles.id = users.role_id');

		return $this->db->where('users.id', $id)->get(self::TABLE_NAME)->row();
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

		return $this->db->get(self::TABLE_NAME)->result();
	}

	/**
	 * Delete User
	 *
	 * @param  int $id
	 * @return void
	 */
	public function delete(int $id): void
	{
		$this->db->where('id', $id)->delete(self::TABLE_NAME);
	}
}
