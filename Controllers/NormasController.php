<?php
namespace Controllers;

use \Core\Controller;
use \Models\Normas;
use \Models\Usuarios;

class NormasController extends Controller {

	public function getNormas() {
		$normas = new Normas();
		$array = array();
		$array = $normas->getAll();

		$this->returnJson($array);
	}

	public function deletaNorma($norma){
		$data = array();
		$retorno = array('error' => '', 'resp' => array());
		$method = $this->getMethod();
		$data = $this->getRequestData();
		$Usuarios = new Usuarios;
		$normas = new Normas();

		if(!empty($data['jwt'] && $Usuarios->validadeJwt($data['jwt']))){
			$delete = $normas->delete($norma);
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

	public function manipulaNorma($norma) {
		$normas = new Normas();
		$Usuarios = new Usuarios;
		$data = array();
		$retorno = array('error' => '', 'resp' => array());
		$method = $this->getMethod();
		$data = $this->getRequestData();

		switch($method){
			case 'GET':
				$retorno['resp'] = $normas->getUnico($norma);
			break;
			case 'PUT':
				if(!empty($data['jwt'] && $Usuarios->validadeJwt($data['jwt']))){
					$update = $normas->update($norma,$data['N_NORMA'],$data['DESCRICAO'],$data['TITULO'],$data['DOWNLOAD']);
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

	public function newNorma(){

		$normas = new Normas();
		$Usuarios = new Usuarios;
		$data = array();
		$retorno = array('error' => '', 'resp' => array());
		$method = $this->getMethod();
		$data = $this->getRequestData();

		if(!empty($data['jwt'] && $Usuarios->validadeJwt($data['jwt']))){
			if($method == 'POST'){
				$retorno['resp'] = $normas->insere($data['N_NORMA'],$data['DESCRICAO'],$data['TITULO'],$data['DOWNLOAD']);
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