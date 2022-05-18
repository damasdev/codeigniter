<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class RoleModel extends MY_Model
{

	public $table = "roles";

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get Role
	 *
	 * @param  string $role
	 * @return array
	 */
	public function role(string $role = 'user'): array
	{
		return $this->db->where('type', $role)->get($this->table)->result();
	}
}
