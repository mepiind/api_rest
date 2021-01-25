<?php
namespace Controllers;

use \Core\Controller;
use \Models\Clientes;
use \Models\Usuarios;

class ClientesController extends Controller {

	public function getClientes() {
	
	
		$Clientes = new Clientes();
		$array = array();
		$array = $Clientes->getAll();

		
		$this->returnJson($array);
	}

	public function deletaCliente($cliente) {
		$Clientes = new Clientes();
		$Usuarios = new Usuarios;
		$data = array();
		$retorno = array('error' => '', 'resp' => array());
		$method = $this->getMethod();
		$data = $this->getRequestData();

		if(!empty($data['jwt'] && $Usuarios->validadeJwt($data['jwt']))){
			$delete = $Clientes->delete($cliente);
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

	public function manipulaCliente($Cliente) {
		$Clientes = new Clientes();
		$Usuarios = new Usuarios;
		$data = array();
		$retorno = array('error' => '', 'resp' => array());
		$method = $this->getMethod();
		$data = $this->getRequestData();

		switch($method){
			case 'GET':
				$data = $Clientes->getUnico($Cliente);
							
				$retorno['resp'] = $data;
			break;
			case 'PUT':
				if(!empty($data['jwt'] && $Usuarios->validadeJwt($data['jwt']))){
					$update = $Clientes->update($Cliente,$data['USUARIO'],$data['SENHA'],$data['CPF'],$data['TELEFONE'],$data['CELULAR'],$data['CIDADE'],$data['ENDERECO'],$data['ESTADO'],$data['CEP'],$data['EMAIL'],$data['SITE'],$data['NOME']);
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

	public function newCliente(){
		$Clientes = new Clientes();
		$Usuarios = new Usuarios;
		$data = array();
		$retorno = array('error' => '', 'resp' => array());
		$method = $this->getMethod();
		$data = $this->getRequestData();

		if(!empty($data['jwt'] && $Usuarios->validadeJwt($data['jwt']))){
			if($method == 'POST'){
				$retorno['resp'] = $Clientes->insere($data['USUARIO'],$data['SENHA'],$data['CPF'],$data['TELEFONE'],$data['CELULAR'],$data['CIDADE'],$data['ENDERECO'],$data['ESTADO'],$data['CEP'],$data['EMAIL'],$data['SITE'],$data['NOME']);
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