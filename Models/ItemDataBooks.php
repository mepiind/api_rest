<?php
namespace Models;

use \Core\Model;
use \Models\Jwt;

class ItemDataBooks extends Model {

	public function getAll() {
		$array = array();

		$sql = "SELECT * FROM Itens_databook ";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}

	public function getAllDataBook($databook) {
		$array = array();

		$sql = "SELECT I.*, P.nome, P.descricao,P.item, P.download, DATE_FORMAT(P.dt_cadastrado,'%d/%m/%Y') as dt_cadastrado  , YEAR(dt_cadastrado) as ANO FROM Itens_databook I JOIN itens P on I.item = P.item WHERE databook =  :databook";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':databook',$databook);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}

	public function getUnico($item_DataBook){
		$data = array();

		$sql = "SELECT item, nome, descricao, download,   DATE_FORMAT(dt_cadastrado,'%d/%m/%Y') as dt_cadastrado FROM itens I WHERE item = :item";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':item',$item_DataBook);
		$sql->execute();

		if($sql->rowCount() > 0){
			$data = $sql->fetch();
		} 

		return $data;
	}

	public function insere($item, $databook){
        
        
        
        
		if($this->db == null){
			$this->redoConnection();
		}
		$sql = "INSERT INTO Itens_databook  ( databook, item) VALUES (:databook, :item)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':databook',$databook);
		$sql->bindValue(':item',$item);
		$sql->execute();

		$resp = $sql->rowCount();
		$this->db = null;
		
		
		

		
		return $resp;

	}
	
	public function insereItem($titulo, $download, $descricao, $data){
        
    
   
		if($this->db == null){
			$this->redoConnection();
		}
		$sql = "INSERT INTO itens  ( nome, descricao, download, dt_cadastrado) VALUES (:titulo, :descricao, :download, STR_TO_DATE( :data , '%d/%m/%Y'))";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':titulo',$titulo);
		$sql->bindValue(':descricao',$descricao);
		$sql->bindValue(':download',$download);
		$sql->bindValue(':data',$data);

		$sql->execute();

	
		if( $sql->rowCount() ){
		    $resp = $this->db->lastInsertId();
		}
		$this->db = null;
	
		
		return $resp;

	}
	
	public function update($nome,$descricao,$download,$item, $data){
	    

		$sql = "UPDATE itens SET nome = :nome, descricao = :descricao, download = :download, dt_cadastrado = STR_TO_DATE( :data , '%d/%m/%Y') WHERE item = :item";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':nome',$nome);
		$sql->bindValue(':descricao',$descricao);
		$sql->bindValue(':download',$download);
		$sql->bindValue(':data',$data);
		$sql->bindValue(':item',$item);
	
		$sql->execute();
		$resp = $sql->rowCount();

		$this->db = null;

		return $resp;

	}

	public function delete($item, $databook){

	
		$sql = "DELETE FROM Itens_databook  WHERE databook = :DataBook and ITEM = :ITEM";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':DataBook',$databook);
        $sql->bindValue(':ITEM',$item);

		$sql->execute();
		
		$sql = "DELETE FROM itens  WHERE ITEM = :ITEM";
		$sql = $this->db->prepare($sql);
        $sql->bindValue(':ITEM',$item);

		$sql->execute();

		$this->db = null;

		

		return $sql->rowCount();

	}
}