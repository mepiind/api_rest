<?php
namespace Models;

use \Core\Model;
use \Models\Jwt;
use PDO;

class DataBooks extends Model {

	public function getAll() {
		$array = array();

		$sql = "SELECT   d.databook, d.titulo, d.setor,  DATE_FORMAT(d.validade,'%d/%m/%Y') as validade FROM Databooks d";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}


	public function getUnico($DataBook) {
		$array = array();

		$sql = "SELECT c.nome AS CLIENTE_NOME, s.nome as SETOR_NOME, D.databook, D.titulo, D.setor, DATE_FORMAT(D.validade,'%d/%m/%Y') as validade, CASE WHEN D.VALIDADE > SYSDATE() THEN 'OK' ELSE 'VENCIDO' END AS STATUS FROM Databooks D JOIN clientes_setores s ON s.setor = D.setor JOIN Clientes c ON c.CLIENTE = s.CLIENTE WHERE DataBook = :DataBook";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':DataBook',$DataBook);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetch(PDO::FETCH_ASSOC);
		}

		return $array;
	}

	public function getDatabooksSetor($setor){
	    
	
		$data = array();
		
		$sql = "SELECT D.databook, D.titulo, D.setor,  DATE_FORMAT(D.validade,'%d/%m/%Y') as validade,  C.*, CASE WHEN D.VALIDADE > SYSDATE() THEN 'OK' ELSE 'VENCIDO' END AS STATUS FROM Databooks D JOIN clientes_setores C ON C.setor = D.setor WHERE C.setor = :setor ";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':setor',$setor);
		
		
		$sql->execute();

		if($sql->rowCount() > 0){
			$data = $sql->fetchAll();
		} 

		return $data;
	}


	public function insere($setor, $validade,$titulo){
		
		$retorno = null;
		

		$sql = "INSERT INTO Databooks (setor, validade,titulo) VALUES (:setor, STR_TO_DATE( :validade , '%d/%m/%Y'),:titulo)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':setor',$setor);
		$sql->bindValue(':validade',$validade);
		$sql->bindValue(':titulo',$titulo);

		$sql->execute();
		if($sql->rowCount() > 0){
			$retorno = $this->db->lastInsertId();
		}
	

		$this->db = null;
		
        return $retorno;
		

	}

	public function update($databook,$setor, $validade,$titulo){
		
		$sql = "UPDATE Databooks SET setor = :setor, validade =STR_TO_DATE( :validade , '%d/%m/%Y'), titulo = :titulo where databook = :databook";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':databook',$databook);
		$sql->bindValue(':setor',$setor);
		$sql->bindValue(':validade',$validade);
		$sql->bindValue(':titulo',$titulo);

		$sql->execute();
		$resp = $sql->rowCount();

		$this->db = null;

		return $resp;

	}

	public function updateNotificacao($databook,$notificacao){

		if($this->db == null){
			$this->redoConnection();
		}

		$sql = "UPDATE Databooks SET notificacao = :notificacao where databook = :databook";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':notificacao',$notificacao);
		$sql->bindValue(':databook',$databook);

		$sql->execute();
		$resp = $sql->rowCount();

		$this->db = null;

		return $resp;

	}

	public function delete($DataBook){
	    
	    //selecionar todos os itens_databooks
	    //deletar todos os itens
	    //deletar todos os itens_databooks

		$sql = "DELETE FROM Databooks WHERE DataBook = :DataBook";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':DataBook',$DataBook);
		$sql->execute();


		$this->db = null;

		return $sql->rowCount();

	}
}