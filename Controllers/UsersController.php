<?php
namespace Controllers;

use \Core\Controller;
use \Models\Usuarios;

class UsersController extends Controller {

	public function index() {
	
	}

	public function login(){
		$array = array('error' => '');

		$method = $this->getMethod();
		$data = $this->getRequestData();

		if($method == 'POST'){
			if(!empty($data['usuario'] && !empty($data['senha']))){
				$Usuarios = new Usuarios();

				//se der certo ele gera o JWT
				if($Usuarios->checkCredentialClientes($data['usuario'],$data['senha'])){
					$array['jwt'] = $Usuarios->createJwt();
				} else {
					$array['error'] = 'Acesso Negado.';
				}
			} else {
				$array['error'] = 'A senha ou email estão em branco.';
			}
		} else {
			$array['error'] = 'Método de requisição incompatível.';
		}

		$this->returnJson($array);
	}
	
	public function loginAdmin(){
		$array = array('error' => '');

		$method = $this->getMethod();
		$data = $this->getRequestData();

		if($method == 'POST'){
			if(!empty($data['usuario'] && !empty($data['senha']))){
				$Usuarios = new Usuarios();

				//se der certo ele gera o JWT
				if($Usuarios->checkCredentialadmin($data['usuario'],$data['senha'])){
					$array['jwt'] = $Usuarios->createJwt();
				} else {
					$array['error'] = 'Acesso Negado.';
				}
			} else {
				$array['error'] = 'A senha ou email estão em branco.';
			}
		} else {
			$array['error'] = 'Método de requisição incompatível.';
		}

		$this->returnJson($array);
	}
}