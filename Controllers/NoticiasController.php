<?php
namespace Controllers;

use \Core\Controller;
use \Models\Noticias;
use \Models\Usuarios;

class NoticiasController extends Controller {

	public function getNoticias() {
		$noticias = new Noticias();
		$array = array();
		$array = $noticias->getAll();
		$this->returnJson($array);
	}

	public function deletaNoticia($noticia) {
		$noticias = new Noticias();
		$Usuarios = new Usuarios;
		$data = array();
		$retorno = array('error' => '', 'resp' => array());
		$method = $this->getMethod();
		$data = $this->getRequestData();

		if(!empty($data['jwt'] && $Usuarios->validadeJwt($data['jwt']))){
			$delete = $noticias->delete($noticia);
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

	public function manipulaNoticia($noticia) {

		$noticias = new Noticias();
		$data = array();
		$retorno = array('error' => '', 'resp' => array());
		$method = $this->getMethod();
		$data = $this->getRequestData();

		switch($method){
			case 'GET':
				$data = $noticias->getUnico($noticia);
				$retorno['resp'] = $data;
			break;
		
			case 'PUT':

				$Usuarios = new Usuarios;
				if(!empty($data['jwt'] && $Usuarios->validadeJwt($data['jwt']))){
					$update = $noticias->update($noticia,$data['DESCRICAO'],$data['DESCRICAO_REDUZ'],$data['LINK_IMG'],$data['TITULO']);
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

	public function newNoticia(){
		
		$noticias = new Noticias();
		$data = array();
		$retorno = array('error' => '', 'resp' => array());
		$method = $this->getMethod();
		$data = $this->getRequestData();
	
		if($method == 'POST'){
			$Usuarios = new Usuarios;
			if(!empty($data['jwt'] && $Usuarios->validadeJwt($data['jwt']))){
				$retorno['resp'] = $noticias->insere($data['DESCRICAO'],$data['DESCRICAO_REDUZ'],$data['LINK_IMG'],$data['TITULO']);
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