<?php
namespace Core;

class Controller {

	public function getMethod()
	{
		return $_SERVER['REQUEST_METHOD'];
	}

	public function getRequestData()
	{
		$method = $this->getMethod();

		switch ($method){
			case 'GET':
				return $_GET;
			break;

			case 'POST':
				$data = json_decode(file_get_contents('php://input'));

				if (is_null($data)){
					$data = $_POST;
				}

				return (array) $data;
			break;

			case 'DELETE':
			case 'PUT':
				$input = file_get_contents('php://input');

				$data = json_decode($input);

			
				return (array) $data;
			break;

		}
	}

	public function  returnJson($array)
	{	
		header ("Content-Type: application/json; charset=UTF-8");
		echo json_encode($array);
	}

	public function getFilesData(){
		return 	$_FILES;
	}



}