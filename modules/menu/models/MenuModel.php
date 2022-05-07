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
	 * @param  mixed $data
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
		return $this->db->where('parent IS NULL')->get(self::TABLE_NAME)->result_array();
	}
}
