<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class RoleModel extends CI_Model
{

	const TABLE_NAME = "roles";

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
	 * Get All Roles
	 *
	 * @return array
	 */
	public function all(): array
	{
		return $this->db->get(self::TABLE_NAME)->result();
	}

	/**
	 * Find By ID
	 *
	 * @param  int $id
	 * @return stdClass
	 */
	public function find(int $id): stdClass
	{
		return $this->db->where('id', $id)->get(self::TABLE_NAME)->row();
	}

	/**
	 * Get Role
	 *
	 * @return array
	 */
	public function role(): array
	{
		return $this->db->where('is_root', 0)->get(self::TABLE_NAME)->result();
	}

	/**
	 * Delete Role
	 *
	 * @param  int $id
	 * @return void
	 */
	public function delete(int $id): void
	{
		$this->db->where('id', $id)->delete(self::TABLE_NAME);
	}
}
