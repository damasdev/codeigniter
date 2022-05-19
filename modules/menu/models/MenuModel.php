<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MenuModel extends MY_Model
{
	public $table = 'menus';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get Parent Menu
	 *
	 * @return array
	 */
	public function parent(): array
	{
		return $this->db->where('parent IS NULL')->get($this->table)->result();
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
			return $this->db->select_max('number')->where('parent IS NULL', NULL, FALSE)->get($this->table)->row()->number ?? 0;
		}

		return $this->db->select_max('number')->where('parent', $parent_id)->get($this->table)->row()->number ?? 0;
	}
}