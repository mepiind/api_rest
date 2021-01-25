<?php
namespace Controllers;

use \Core\Controller;
use \Models\Menus;

class MenusController extends Controller {

	public function getMenus() {
		$menus = new Menus();
		$array = array();
		$array = $menus->getAll();

		$this->returnJson($array);
	}
	public function getMenusCategoria($categoria) {
	    
		$menus = new Menus();
		$array = array();
		$array = $menus->getUnico($categoria);

		$this->returnJson($array);
	}

	public function getMenusTipo($tipo) {
	    
	    
	    
		$menus = new Menus();
		$array = array();
		$array = $menus->getTipo($tipo);

		$this->returnJson($array);
	}

	public function manipulaMenu($menu) {
		$menus = new Menus();
		$data = array();
		$retorno = array('error' => '', 'resp' => array());
		$method = $this->getMethod();
		$data = $this->getRequestData();

		switch($method){
			case 'GET':
				$retorno['resp'] = $menus->getUnico($menu);
			break;
		
			case 'PUT':
				$update = $menus->update($menu,$data['PAI_CATEGORIA'],$data['TIPO'],$data['DESCRICAO']);
				if( $update == 0){
					$retorno['error'] = 'falhou';
				} else {
					$retorno['resp'] = $update;
				}
			break;

			case 'DELETE':
				$delete = $menus->delete($menu);
				if($delete == 0){
					$retorno['error'] = 'falhou';
				} else {
					$retorno['resp'] = $delete;
				}
				
			break;
		}

		$this->returnJson($retorno);
	}

	public function newMenu(){

		$menus = new Menus();
		$data = array();
		$retorno = array('error' => '', 'resp' => array());
		$method = $this->getMethod();
		$data = $this->getRequestData();

		if($method == 'POST'){
			$retorno['resp'] = $menus->insere($data['PAI_CATEGORIA'],$data['TIPO'],$data['DESCRICAO']);
		} else {
			$retorno['error'] = 'method errado';
		}
		
		if($retorno['resp'] == 0){
			$retorno['error'] = 'falhou_insert';
		}

		$this->returnJson($retorno);
	}

}