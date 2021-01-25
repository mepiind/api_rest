<?php
namespace Models;

use \Core\Model;
use \Models\Jwt;

class Usuarios extends Model {

	public function getAll() {
		$array = array();

		$sql = "SELECT * FROM usuarios";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}

	private $id_user;

	public function checkCredentialClientes($usuario,$senha){
		$data = array();

		$sql = "SELECT usuario, senha FROM Clientes WHERE usuario like :usuario and :senha = senha";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':usuario',$usuario);
		$sql->bindValue(':senha',$senha);
		$sql->execute();


		if($sql->rowCount() > 0){
			$data = $sql->fetch();
			if($senha == $data['SENHA']){
				$this->id_user = $data['USUARIO'];

				return true;
			} else {
				return false;
			}

		} else {
			return false;
		}

		
	}

	public function checkCredentialadmin($usuario,$senha){
		$data = array();
	

		$sql = "SELECT login, senha FROM usuarios WHERE login like :usuario and senha = :senha";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':usuario',$usuario);
		$sql->bindValue(':senha',$senha);
		$sql->execute();
        

		if($sql->rowCount() > 0){
			$data = $sql->fetch();
			if($senha == $data['SENHA']){
				$this->id_user = $data['LOGIN'];

				return true;
			} else {
				return false;
			}

		} else {
			return false;
		}

		
	}

	public function createJwt(){
		$jwt = new Jwt();
		return $jwt->create(array('id_user' => $this->id_user));
	}

	public function validadeJwt($token){
		$jwt = new Jwt(); 
		$info = array();

		

		$info = $jwt->validate($token);
		if(isset($info->id_user)){
			$this->id_user = $info->id_user;
			return true;
		} else {
			return false;
		}
	}

}