<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');

class Backupcron_model extends CI_Model 
{
	public function __construct() 
	{
        parent::__construct();
		ini_set('memory_limit', '-1');
    }
	
	public function db_details()
	{
		$result = array (
		 'database' =>  $this->db->database,		
		 'password' =>  $this->db->password,		
		 'username' =>  $this->db->username,		
		 'host' 	=>  $this->db->hostname	
		); 
		return $result;
	}

}