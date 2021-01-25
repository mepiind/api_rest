<?php
namespace Controllers;

use \Core\Controller;
use \Models\ItemDataBooks;
use \Models\Usuarios;

class ItensDatabooksController extends Controller {

	public function getItensDataBooks() {
		$ItensDataBooks = new ItemDataBooks();
		$array = array();
		$array = $ItensDataBooks->getAll();

		$this->returnJson($array);
	}

	public function getItensDataBooksDatabook(){

		$data = $this->getRequestData();
		$method = $this->getMethod();
		$Usuarios = new Usuarios;
		$array = array('error' => '', 'resp' => array());
	//	if(!empty($data['jwt'] && $Usuarios->validadeJwt($data['jwt']))){
			$ItemDataBooks = new ItemDataBooks();
			$array['resp'] = $ItemDataBooks->getAllDataBook($data['databook']);
	//	} else {
			//$array['error'] = 'Falha de autenticação.';
	//	}

		
		$this->returnJson($array);
	}
	
	public function deleteDataBooks($item) {
	    $ItensDataBooks = new ItemDataBooks();
		$Usuarios = new Usuarios;
		$data = array();
		$retorno = array('error' => '', 'resp' => array());
		$method = $this->getMethod();
		$data = $this->getRequestData();

		if(!empty($data['jwt'] && $Usuarios->validadeJwt($data['jwt']))){
			
			$delete = $ItensDataBooks->delete($item,$data['databook']);
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

	public function manipulaItensDataBook($itemDatabook) {
		$ItensDataBooks = new ItemDataBooks();
		$data = array();
		$retorno = array('error' => '', 'resp' => array());
		$method = $this->getMethod();
		$data = $this->getRequestData();

		switch($method){
			case 'GET':
				$retorno['resp'] = $ItensDataBooks->getUnico($itemDatabook);
			break;
			
			case 'POST':
				$retorno['resp'] = $ItensDataBooks->getUnico($itemDatabook);
			break;

			case 'PUT': 
				$update = $ItensDataBooks->update($data['NOME'], $data['DESCRICAO'], $data['DOWNLOAD'], $itemDatabook,  $data['DT_CADASTRADO']);
				if( $update == 0){
					$retorno['error'] = 'falhou';
				} else {
					$retorno['resp'] = $update;
				}
			break;
			
			case 'DELETE':
				$delete = $ItensDataBooks->delete($itemDatabook, $data['databook']);
				if($delete == 0){
					$retorno['error'] = 'falhou';
				} else {
					$retorno['resp'] = $delete;
				}
				
			break;
		}

		$this->returnJson($retorno);
	}

	public function newItensDataBook(){

		$ItensDataBooks = new ItemDataBooks();
		$data = array();
		$retorno = array('error' => '', 'resp' => array());
		$method = $this->getMethod();
		$data = $this->getRequestData();

		if($method == 'POST'){
			$retorno['resp'] = $ItensDataBooks->insereItem($data['NOME'], $data['DOWNLOAD'], $data['DESCRICAO'], $data['DT_CADASTRADO']);
	;
			
			if($retorno['resp'] != null){
			   $retorno['resp'] = $ItensDataBooks->insere($retorno['resp'], $data['DATABOOK']); 
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