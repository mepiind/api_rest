<?php
namespace Controllers;

use \Core\Controller;
use \Models\Clientes;

class UploadController extends Controller {

	public function saveUpload() {
		$files = $this->getFilesData();


		$file_name = $files["fileKey"]["name"];
		$target_path = dirname( dirname(__FILE__) )."/uploads/". $file_name;
		if(move_uploaded_file($files["fileKey"]["tmp_name"],$target_path. $file_name)){
			echo 'deu certo';
		} else {
			echo 'não deu';
		}
	}
	
}