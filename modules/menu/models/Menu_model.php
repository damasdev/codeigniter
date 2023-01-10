<?php

class Menu_model extends MY_Model
{
	public $table = 'menus';


	/**
	 * Get Parent Menu
	 *
	 * @return array
	 */
	public function parent(): array
	{
		return $this->db->where('parent IS null')->get($this->table)->result();
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
			return $this->db->select_max('number')->where('parent IS null', null, false)->get($this->table)->row()->number ?? 0;
		}

		return $this->db->select_max('number')->where('parent', $parent_id)->get($this->table)->row()->number ?? 0;
	}

	/**
	 * All Menu With ACL
	 *
	 * @param  array $conditions
	 * @return ?array
	 */
	public function allWithAcl(array $conditions = []): ?array
	{
		$this->db->select([
			'menus.id', 'menus.icon', 'menus.slug', 'menus.name', 'menus.parent', 'menus.number'
		])->join('menus_acl', 'menus_acl.menu_id = menus.id', 'LEFT');

		return $this->all($conditions);
	}
}
