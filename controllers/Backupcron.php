<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Backupcron extends CI_Controller {

   	public function __construct()
	{
		parent::__construct();
		$this->load->model('backupcron_model');
	}
		
	public function index(){
		$pastdays = "-3 days"; // past days from today to delete backup 
		
	$db = $this->backupcron_model->database();
	$date = date('d-m-y', time()); 
	$folder = 'DB_Backup/';
	$filename = $folder."db-".$db."-".$date; 
	
	if(file_exists($filename.'.sql') ==1 )
	{
		echo "Backup Already Exists with filname ".$filename;
		exit;		
	}

	$return = $this->backupcron_model->all_tables();


// Create Backup Folder
$folder = 'DB_Backup/';
if (!is_dir($folder))
mkdir($folder, 0777, true);
chmod($folder, 0777);

$date = date('d-m-y', time()); 

$filename = $folder."db-".$db."-".$date; 
$sdate = date('d-m-y',  strtotime($pastdays) );
$old_filename = $folder."db-".$db."-".$sdate; 

$handle = fopen($filename.'.sql','w+');
$status = fwrite($handle,$return);
if($status !== false)
{
	echo "Database backup Success, db-".$db."-".$sdate." file is saved to DB_Backup folder in your root directory";
	if ( file_exists($filename.'.sql') == 1)
	{ 
		if( file_exists($old_filename.'.sql')  == 1)
		unlink($old_filename.'.sql');
	}
}

fclose($handle);
}




}
