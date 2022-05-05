<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

class UserModel extends CI_Model
{
	const TABLE_NAME = "users";

	public function __construct()
	{
		parent::__construct();
	}
}