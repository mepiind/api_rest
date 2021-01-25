<?php
namespace Controllers;

use \Core\Controller;
use \Models\Produtos;
use \Models\Usuarios;


class ProdutosController extends Controller {

	public function getProdutos() {
		$Produtos = new Produtos();
		$array = array();
		$array = $Produtos->getAll();

		$this->returnJson($array);
	}

	public function deletaProduto($produto){
		$data = array();
		$retorno = array('error' => '', 'resp' => array());
		$method = $this->getMethod();
		$data = $this->getRequestData();
		$Usuarios = new Usuarios;
		$Produtos = new Produtos();

		if(!empty($data['jwt'] && $Usuarios->validadeJwt($data['jwt']))){
			$delete = $Produtos->delete($produto);
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

	public function getProdutoCategoria($categoria) {
		$Produtos = new Produtos();
		$array = array();
		$array = $Produtos->getAllCategoria($categoria);

		$this->returnJson($array);
	}

	public function manipulaProduto($Produto) {
		$Produtos = new Produtos();
		$Usuarios = new Usuarios;
		$data = array();
		$retorno = array('error' => '', 'resp' => array());
		$method = $this->getMethod();
		$data = $this->getRequestData();

		switch($method){
			case 'GET':
				$retorno['resp'] = $Produtos->getUnico($Produto);
			break;
			case 'PUT':
				if(!empty($data['jwt'] && $Usuarios->validadeJwt($data['jwt']))){
					$update = $Produtos->update($Produto,$data['CATEGORIA'],$data['LINK_FOTO'],$data['CODIGO'],$data['NORMA'],$data['CA'],$data['MARCA'],$data['CARACTERISTICAS'],$data['DESCRICAO'],$data['APLICACAO'],$data['INFORMACAO'],$data['ADICIONAIS'],$data['LINK_FOTO_REAL']);
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

	public function newProduto(){

		$Produtos = new Produtos();
		$Usuarios = new Usuarios;
		$data = array();
		$retorno = array('error' => '', 'resp' => array());
		$method = $this->getMethod();
		$data = $this->getRequestData();

		if(!empty($data['jwt'] && $Usuarios->validadeJwt($data['jwt']))){
			if($method == 'POST'){
				$retorno['resp'] = $Produtos->insere($data['CATEGORIA'],$data['LINK_FOTO'],$data['CODIGO'],$data['NORMA'],$data['CA'],$data['MARCA'],$data['CARACTERISTICAS'],$data['DESCRICAO'],$data['APLICACAO'],$data['INFORMACAO'],$data['ADICIONAIS'],$data['LINK_FOTO_REAL']);
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