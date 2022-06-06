<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

class FeatureAclModel extends MY_Model
{

	public $table = "features_acl";

	public function __construct()
	{
		parent::__construct();
	}
}