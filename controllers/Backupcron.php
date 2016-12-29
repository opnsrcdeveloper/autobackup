<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Backupcron extends CI_Controller 
{

   	public function __construct()
	{
		parent::__construct();
		$this->load->model('backupcron_model');
	}
	
	public function dobckup() 
	{
		$folder = 'DB_Backup/';
		if (!is_dir($folder))
		mkdir($folder, 0777, true);
		chmod($folder, 0777);

		$pastdays = "-3 days"; // past days from today to delete backup 
		$db = $this->backupcron_model->db_details(); // get db details 
		$date = date('d-m-y', time());
		$sdate = date('d-m-y',  strtotime($pastdays) );
		$folder = 'DB_Backup';		
		$filename = $folder."\db-".$db['database']."-".$date.'.sql';
		$old_filename = $folder."\db-".$db['database']."-".$sdate.'.sql';
		
		if(file_exists($filename) ==1 )
		{
			echo "Backup Already Exists with filname ".$filename;
			exit;		
		}
		else
		{
			$cmd = 'D:\xampp\mysql\bin\mysqldump --user=' .$db['username'].' --password=  '. $db['password'] .'     --host='.$db['host'].'  '.$db['database'].' > '.FCPATH.$filename;
			system($cmd,$return);
			if( $return == 0 )
			{
				if( file_exists($old_filename)  == 1)
				unlink($old_filename);
			}
		}
	}
}