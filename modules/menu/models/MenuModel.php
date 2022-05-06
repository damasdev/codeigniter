<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

class MenuModel extends CI_Model
{
	const TABLE_NAME = 'menus';

	public function __construct()
	{
		parent::__construct();
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
}