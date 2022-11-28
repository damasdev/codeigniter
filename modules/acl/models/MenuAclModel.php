<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

class MenuAclModel extends MY_Model
{

	public $table = "menus_acl";

	public function __construct()
	{
		parent::__construct();
	}
}