<?php
namespace Controllers;

use \Core\Controller;
use \Models\Setores;
use \Models\Usuarios;

class SetoresController extends Controller {

	public function getSetoresClientes($cliente) {
	
	    
		$Setores = new Setores();
		$array = array();
		$array = $Setores->getAllClientes($cliente);

		
		$this->returnJson($array);
	}
	
	
	public function getSetoresCliente(){
	    

		$data = $this->getRequestData();
		$method = $this->getMethod();
		$Usuarios = new Usuarios;
		$array = array('error' => '', 'resp' => array());
		if(!empty($data['jwt'] && $Usuarios->validadeJwt($data['jwt']))){
				$Setores = new Setores();
        		$array = array();
        		$array['resp'] = $Setores->getAllClientes($data['user']);
                
        		
		} else {
			$array['error'] = 'Falha de autenticação.';
		}

		
		$this->returnJson($array);
	}
	
	
	
	public function getSetores() {
	
	
		$Setores = new Setores();
		$array = array();
		$array = $Setores->getAll();

		
		$this->returnJson($array);
	}

	public function deletaSetor($setor) {
		$Setores = new Setores();
		$Usuarios = new Usuarios;
		$data = array();
		$retorno = array('error' => '', 'resp' => array());
		$method = $this->getMethod();
		$data = $this->getRequestData();

		if(!empty($data['jwt'] && $Usuarios->validadeJwt($data['jwt']))){
			$delete = $Setores->delete($setor);
			if($delete == 0){
				$retorno['error'] = 'falhou';
			} else {
				$retorno['resp'] = $delete;
			}
		} else {
			$retorno['error'] = 'Falha de autenticação.';
		}

		$this->returnJson($retorno);
	}

	public function manipulaSetor($setor) {
		$Setores = new Setores();
		$Usuarios = new Usuarios;
		$data = array();
		$retorno = array('error' => '', 'resp' => array());
		$method = $this->getMethod();
		$data = $this->getRequestData();

		switch($method){
			case 'GET':
				$data = $Setores->getUnico($setor);
							
				$retorno['resp'] = $data;
			break;
			case 'PUT':
				if(!empty($data['jwt'] && $Usuarios->validadeJwt($data['jwt']))){
					$update = $Setores->update($setor,$data['SELECTEDSETOR'],$data['NOME']);
					if( $update == 0){
						$retorno['error'] = 'falhou';
					} else {
						$retorno['resp'] = $update;
					}
				} else {
					$retorno['error'] = 'Falha de autenticação.';
				}
				
			break;

		}

		$this->returnJson($retorno);
	}

	public function newSetor(){
		$Setores = new Setores();
		$Usuarios = new Usuarios;
		$data = array();
		$retorno = array('error' => '', 'resp' => array());
		$method = $this->getMethod();
		$data = $this->getRequestData();

		if(!empty($data['jwt'] && $Usuarios->validadeJwt($data['jwt']))){
			if($method == 'POST'){
				$retorno['resp'] = $Setores->insere($data['SELECTEDSETOR'],$data['NOME']);
			} else {
				$retorno['error'] = 'method errado';
			}
			if($retorno['resp'] == 0){
				$retorno['error'] = 'falhou_insert';
			}
		} else {
			$retorno['error'] = 'Falha de autenticação.';
		}

		$this->returnJson($retorno);
	}

}