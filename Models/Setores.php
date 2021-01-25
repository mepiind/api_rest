<?php
namespace Models;

use \Core\Model;
use \Models\Jwt;
use PDO;

class Setores extends Model {

	public function getAllClientes($cliente) {
		$array = array();

		$sql = "SELECT SETOR AS ID, s.NOME as SETOR, c.NOME as CLIENTE FROM clientes_setores s JOIN Clientes c ON c.CLIENTE = s.CLIENTE WHERE c.CLIENTE = :cliente or c.USUARIO = :cliente";


		
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':cliente',$cliente);
		$sql->execute();


		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		
		}

		return $array;
	}
	
	public function getAll() {
		$array = array();
		$sql = "SELECT SETOR AS ID, s.NOME as SETOR, c.NOME as CLIENTE FROM clientes_setores s JOIN Clientes c ON c.CLIENTE = s.CLIENTE";

		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}

	public function getUnico($setor){
		$data = array();
		$sql = "SELECT SETOR AS ID, s.NOME as SETOR, c.NOME, c.CLIENTE as CLIENTEID FROM clientes_setores s JOIN Clientes c ON c.CLIENTE = s.CLIENTE WHERE s.SETOR = :SETOR";
		
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':SETOR',$setor);
		$sql->execute();
		

		
		if($sql->rowCount() > 0){
			$data = $sql->fetch(PDO::FETCH_ASSOC);
		} 

		return $data;
	}

	public function insere($cliente, $nome){
		
		$sql = "INSERT INTO clientes_setores (cliente,nome) VALUES (:cliente,:nome)";
		$sql = $this->db->prepare($sql);

		$sql->bindValue(':cliente',$cliente);
		$sql->bindValue(':nome',$nome);

		
		$sql->execute();
		$resp = $sql->rowCount();

		
		$this->db = null;
		
		return $resp;
	}

	public function update($setor, $cliente, $nome){
		
		$sql = "UPDATE clientes_setores SET nome = :nome, cliente = :cliente where setor = :setor";
		$sql = $this->db->prepare($sql);

		$sql->bindValue(':nome',$nome);
		$sql->bindValue(':setor',$setor);
		$sql->bindValue(':cliente',$cliente);
	
		$sql->execute();

		$resp = $sql->rowCount();

		$this->db = null;

		return $resp;

	}

	public function delete($setor){
	
		$sql = "DELETE FROM clientes_setores WHERE setor = :setor";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':setor',$setor);

		$sql->execute();

		$this->db = null;

		return $sql->rowCount();

	}

}