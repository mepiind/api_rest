<?php
namespace Controllers;

use \Core\Controller;
use \Models\Menus;
use \Models\Usuarios;
use \Models\Produtos;

class MenusController extends Controller {

	public function getMenus() {
		$menus = new Menus();
		$Produtos = new Produtos();
		$array = array();
		$array = $menus->getAll();
		
		foreach($array as $key => $menu ){

            $array[$key]['PRODUTOS'] =  	$Produtos->getAllCategoria($menu['CATEGORIA']);
		}

		$this->returnJson($array);
	}
	public function getMenusCategoria($categoria) {
	    
		$menus = new Menus();
		$array = array();
		$array = $menus->getUnico($categoria);

		$this->returnJson($array);
	}

	public function getMenusCategoriaPai($categoria) {
	    
		$menus = new Menus();
		$array = array();
		$array = $menus->getUnicoPai($categoria);

		$this->returnJson($array);
	}

	public function getMenusTipo($tipo) {
	    
	    
	    
		$menus = new Menus();
		$array = array();
		$array = $menus->getTipo($tipo);

		$this->returnJson($array);
	}

	public function deletaMenu($menu){
		$data = array();
		$retorno = array('error' => '', 'resp' => array());
		$method = $this->getMethod();
		$data = $this->getRequestData();
		$Usuarios = new Usuarios;
		$menus = new Menus();

		if(!empty($data['jwt'] && $Usuarios->validadeJwt($data['jwt']))){
			$delete = $menus->delete($menu);
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

	public function manipulaMenu($menu) {
		$menus = new Menus();
		$Usuarios = new Usuarios;
		$data = array();
		$retorno = array('error' => '', 'resp' => array());
		$method = $this->getMethod();
		$data = $this->getRequestData();

		switch($method){
			case 'GET':
				$retorno['resp'] = $menus->getUnico($menu);
			break;
		
			case 'PUT':

				if(!empty($data['jwt'] && $Usuarios->validadeJwt($data['jwt']))){
					$update = $menus->update($menu,$data['PAI_CATEGORIA'],$data['TIPO'],$data['DESCRICAO'],$data['ICONE']);
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

	public function newMenu(){
		$Usuarios = new Usuarios;
		$menus = new Menus();
		$data = array();
		$retorno = array('error' => '', 'resp' => array());
		$method = $this->getMethod();
		$data = $this->getRequestData();

		if(!empty($data['jwt'] && $Usuarios->validadeJwt($data['jwt']))){
			if($method == 'POST'){
				$retorno['resp'] = $menus->insere($data['PAI_CATEGORIA'],$data['TIPO'],$data['DESCRICAO'], $data['ICONE']);
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