<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class UserModel extends MY_Model
{
	public $table = "users";

	public function __construct()
	{
		parent::__construct();
	}
}
