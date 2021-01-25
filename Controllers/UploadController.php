<?php
namespace Controllers;

use \Core\Controller;

class UploadController extends Controller {

	public function saveUpload() {
		$files = $this->getFilesData();
		ini_set('display_errors',1);
		$file_name = $files["fileKey"]["name"];
		$tmp_name = $files["fileKey"]["tmp_name"];
		$target_path = dirname(__FILE__) ."/files/";
		$retorno = null;
		
		$allowed = array('gif', 'png', 'jpg', 'pdf', 'jpeg');
       
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (in_array($ext, $allowed)) {
           	$retorno['error'] = 'extensão não permitida';
        } else {
            if(file_exists($target_path . $file_name)) {
    			chmod($target_path . $file_name, 777); //Change the file permissions if allowed
    			unlink($target_path . $file_name); //remove the file
    		}
    
    		if (!move_uploaded_file($tmp_name ,$target_path . $file_name )) {
    			$retorno['error'] = 'method errado';
    		} else {
    		   	$retorno['resp'] =  $file_name;
    		}
        }
		

		

		$this->returnJson($retorno);

	}
}