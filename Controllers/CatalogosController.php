<?php
namespace Controllers;

use \Core\Controller;
use \Models\Catalogos;
use \Models\Usuarios;


class CatalogosController extends Controller {

	public function getCatalogos() {
		$catalogos = new Catalogos();
		$array = array();
		$array = $catalogos->getAll();
		
		foreach($array as $key => $catalogo ){

            $array[$key]['PRODUTOS'] =  $catalogos->getCatalgosProdutos($catalogo['CATALOGO']);
		}
		
		$this->returnJson($array);
	}

	public function deletaCatalogos($noticia) {
		$catalogos = new Catalogos();
		$Usuarios = new Usuarios;
		$data = array();
		$retorno = array('error' => '', 'resp' => array());
		$method = $this->getMethod();
		$data = $this->getRequestData();

		if(!empty($data['jwt'] && $Usuarios->validadeJwt($data['jwt']))){
			$delete = $catalogos->delete($noticia);
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

	public function manipulaCatalogos($catalogo) {

		$catalogos = new Catalogos();
		$data = array();
		$retorno = array('error' => '', 'resp' => array());
		$method = $this->getMethod();
		$data = $this->getRequestData();

		switch($method){
			case 'GET':
				$data = $catalogos->getUnico($catalogo);
				$retorno['resp'] = $data;
				$produtos =  $catalogos->getAllProdutosCatalogos($catalogo);
				foreach($produtos as $produto){
				    	$retorno['resp']['PRODUTOS'][] = $produto['PRODUTO'];
				}
			break;
		
			case 'PUT':

				$Usuarios = new Usuarios;
				if(!empty($data['jwt'] && $Usuarios->validadeJwt($data['jwt']))){
					$update = $catalogos->update($catalogo,$data['IFRAME'],$data['LINK_IMG'],$data['TITULO']);
					if( $update == 0){
						$retorno['error'] = 'falhou';
					} else {
						$retorno['resp'] = $update;
						
					}
					
					if($catalogos->deletaProdutos($catalogo) == 1){
					    $retorno['resp'] = 1;
					    $retorno['error'] = "";
					}
					//tem que deletar primeiro..
					 foreach($data['PRODUTOS'] as $produto){
						$catalogos->insereProdutos($catalogo,$produto);
						$retorno['resp'] = 1;
					    $retorno['error'] = "";
					}
					
				} else {
					$retorno['error'] = 'Falha de autenticação.';
				}

				
			break;

			
		}

		$this->returnJson($retorno);
	}

	public function newCatalogos(){
		
		$catalogos = new Catalogos();
		$data = array();
		$retorno = array('error' => '', 'resp' => array());
		$method = $this->getMethod();
		$data = $this->getRequestData();
	
		if($method == 'POST'){
			$Usuarios = new Usuarios;
			if(!empty($data['jwt'] && $Usuarios->validadeJwt($data['jwt']))){
				$retorno['resp'] = $catalogos->insere($data['IFRAME'],$data['LINK_IMG'],$data['TITULO']);
				
				    foreach($data['PRODUTOS'] as $produto){
						$catalogos->insereProdutos( 	$retorno['resp'], $produto);
					}
				
			} else {
				$retorno['error'] = 'Falha de autenticação.';
			}
		
		} else {
			$retorno['error'] = 'method errado';
		}
		
		if($retorno['resp'] == 0){
			$retorno['error'] = 'falhou_insert';
		}

		$this->returnJson($retorno);
	}

}