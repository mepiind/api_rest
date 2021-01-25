<?php
namespace Controllers;

use \Core\Controller;
use \Models\Usuarios;

class HomeController extends Controller {

	public function index() {
		var_dump($this->getRequestData());

		$this->returnJson([
			'teste' => 'teste',
			'teste3' => 'teste',
			'teste4' => 'teste'
		]);
	}

	public function testando(){
		$array = array('error' => '', 'logged' => false);
		$method = $this->getMethod();
		$data = $this->getRequestData();

		$Usuarios = new Usuarios;

		
		if(!empty($data['jwt'] && $Usuarios->validadeJwt($data['jwt']))){
			$array['logged'] = true;
		}

		$this->returnJson($array);
	}

	public function visualizar_usuarios($id){
		echo $id;
	}

}