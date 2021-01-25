<?php
namespace Controllers;

use \Core\Controller;
use \Models\DataBooks;
use \Models\Usuarios;
use \Models\ItemDataBooks;
use \Core\Model;

class DataBooksController extends Controller {

	public function getDataBooks() {
		$DataBooks = new DataBooks();
		$array = array();
		$array = $DataBooks->getAll();

		$this->returnJson($array);
	}

	public function getDataBookSetores(){
		$data = $this->getRequestData();
		$method = $this->getMethod();
		$Usuarios = new Usuarios;
		$array = array('error' => '', 'resp' => array());
		if(!empty($data['jwt'] && $Usuarios->validadeJwt($data['jwt']))){
			$DataBooks = new DataBooks();
			$array['resp'] = $DataBooks->getDatabooksSetor($data['setor']);
		} else {
			$array['error'] = 'Falha de autenticação.';
		}

		
		$this->returnJson($array);
	}

	public function deleteDataBooks($DataBook) {
		$DataBooks = new DataBooks();
		$Usuarios = new Usuarios;
		$data = array();
		$retorno = array('error' => '', 'resp' => array());
		$method = $this->getMethod();
		$data = $this->getRequestData();

		if(!empty($data['jwt'] && $Usuarios->validadeJwt($data['jwt']))){
			$ItemDataBooks = new ItemDataBooks();
			$ItemDataBooks->delete($DataBook);

			$delete = $DataBooks->delete($DataBook);
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


	public function manipulaDataBook($DataBook) {
		$DataBooks = new DataBooks();
		$Usuarios = new Usuarios;
		$data = array();
		$retorno = array('error' => '', 'resp' => array());
		$method = $this->getMethod();
		$data = $this->getRequestData();

		switch($method){
			case 'GET':
				$retorno['resp'] = $DataBooks->getUnico($DataBook);
				$DataBooksItens = new ItemDataBooks();
				
				$retorno['resp']['ITENS'] =  $DataBooksItens->getAllDataBook($DataBook);
			break;
								
			case 'PUT':
				if(!empty($data['jwt'] && $Usuarios->validadeJwt($data['jwt']))){
					$update = $DataBooks->update($DataBook,$data['SETOR'],$data['VALIDADE'],$data['TITULO']);
				
					if( $update == 0){
						$retorno['error'] = 'falhou';
					} else {
						$retorno['resp'] = $update;
					}
				} else {
					$array['error'] = 'Falha de autenticação.';
				}
			
			break;

		}

		$this->returnJson($retorno);
	}

	public function newDataBook(){
		$Usuarios = new Usuarios;
		$DataBooks = new DataBooks();
		$data = array();
		$retorno = array('error' => '', 'resp' => array());
		$method = $this->getMethod();
		$data = $this->getRequestData();

		if($method == 'POST'){

			if(!empty($data['jwt'] && $Usuarios->validadeJwt($data['jwt']))){
				$retorno['resp'] = $DataBooks->insere($data['SETOR'],$data['VALIDADE'],$data['TITULO']);
			
				if($retorno['resp'] == 0){
					$retorno['error'] = 'falhou_insert';
				}
			} else {
				$array['error'] = 'Falha de autenticação.';
			}
			
		} else {
			$retorno['error'] = 'method errado';
		}
		
		

		$this->returnJson($retorno);
	}

}