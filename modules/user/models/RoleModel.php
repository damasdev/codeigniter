<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class RoleModel extends CI_Model
{
	const TABLE_NAME = "roles";

	public function __construct()
	{
		parent::__construct();
	}
}
