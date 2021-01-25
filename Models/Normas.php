<?php
namespace Models;

use \Core\Model;
use \Models\Jwt;
use PDO;

class Normas extends Model {

	public function getAll() {
		$array = array();

		$sql = "SELECT * FROM Normas ORDER BY n_norma";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll(PDO::FETCH_ASSOC);
		}

		return $array;
	}
	
	public function getUnico($norma){

		$data = array();
		
		$sql = "SELECT * FROM Normas WHERE norma = :norma";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':norma',$norma);
		$sql->execute();

		if($sql->rowCount() > 0){
			$data = $sql->fetch(PDO::FETCH_ASSOC);
		} 

		return $data;
	}

	public function insere($nNorma, $descricao, $titulo, $download){
		
		$sql = "INSERT INTO Normas (n_norma, descricao, titulo, download) VALUES (:n_norma, :descricao, :titulo, :download)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':n_norma',$nNorma);
		$sql->bindValue(':descricao',$descricao);
		$sql->bindValue(':titulo',$titulo);
		$sql->bindValue(':download',$download);

		$sql->execute();
		$resp = $sql->rowCount();
		$this->db = null;
		
		return $resp;

	}

	public function update($norma, $nNorma, $descricao, $titulo, $download){
		
		$sql = "UPDATE Normas SET n_norma = :n_norma, descricao = :descricao, titulo =  :titulo, download = :download where norma = :norma";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':n_norma',$nNorma);
		$sql->bindValue(':descricao',$descricao);
		$sql->bindValue(':titulo',$titulo);
		$sql->bindValue(':download',$download);
		$sql->bindValue(':norma',$norma);

		$sql->execute();
		$resp = $sql->rowCount();

		$this->db = null;

		return $resp;

	}

	public function delete($norma){
	
		$sql = "DELETE FROM Normas WHERE NORMA = :norma";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':norma',$norma);

		$sql->execute();

		$this->db = null;

		return $sql->rowCount();

	}


}