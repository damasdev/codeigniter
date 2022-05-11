<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MenuModel extends CI_Model
{
	const TABLE_NAME = 'menus';

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
	 * Find By ID
	 *
	 * @param  int $id
	 * @return ?stdClass
	 */
	public function find(int $id): ?stdClass
	{
		return $this->db->where('id', $id)->get(self::TABLE_NAME)->row();
	}

	/**
	 * Get all menus
	 *
	 * @return array
	 */
	public function all(): array
	{
		return $this->db->get(self::TABLE_NAME)->result_array();
	}

	/**
	 * Get Parent Menu
	 *
	 * @return array
	 */
	public function parent(): array
	{
		return $this->db->where('parent IS NULL')->get(self::TABLE_NAME)->result();
	}

	/**
	 * Delete Menu
	 *
	 * @param  int $id
	 * @return void
	 */
	public function delete(int $id): void
	{
		$this->db->where('id', $id)->delete(self::TABLE_NAME);
	}
	
	/**
	 * current
	 *
	 * @param  ?string $parent_id
	 * @return int
	 */
	public function current(?string $parent_id): int
	{
		if (is_null($parent_id)) {
			return $this->db->select_max('number')->where('parent IS NULL', NULL, FALSE)->get(self::TABLE_NAME)->row()->number ?? 0;
		}

		return $this->db->select_max('number')->where('parent', $parent_id)->get(self::TABLE_NAME)->row()->number ?? 0;
	}
}
