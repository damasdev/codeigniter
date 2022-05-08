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
}
