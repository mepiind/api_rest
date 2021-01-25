<?php
namespace Models;

use \Core\Model;
use \Models\Jwt;
use PDO;

class Menus extends Model {

	public function getAll() {
		$array = array();

		$sql = "SELECT CAT.*, CAT2.DESCRICAO AS DESCPAI, CASE CAT.TIPO WHEN 1 THEN 'Serviços' WHEN 2 THEN 'EPI' WHEN 3 THEN 'Linha de Vida'  END AS TIPOCAT FROM categorias CAT LEFT JOIN categorias CAT2 ON CAT.PAI_CATEGORIA= CAT2.CATEGORIA";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll(PDO::FETCH_ASSOC);
		}

		return $array;
	}

	public function getTipo($tipo) {
		$array = array();
	
		$sql = "SELECT * FROM categorias WHERE tipo = :tipo and pai_categoria is NULL";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':tipo',$tipo);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll(PDO::FETCH_ASSOC);
		}

		return $array;
	}
	
	public function getUnico($categoria){
	    
    	$array = array();
		
		$sql = "SELECT * FROM categorias WHERE categoria = :categoria";
		
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':categoria',$categoria);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetch(PDO::FETCH_ASSOC);
		}

		return $array;
	}

	public function getUnicoPai($categoria){
	    
    	$array = array();
		
		$sql = "SELECT * FROM categorias WHERE pai_categoria = :pai_categoria";
		
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':pai_categoria',$categoria);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll(PDO::FETCH_ASSOC);
		}

		return $array;
	}

	public function insere($pai_categoria, $tipo, $descricao, $icone){
		
		$sql = "INSERT INTO categorias (pai_categoria, tipo, descricao, icone) VALUES (:pai_categoria, :tipo, :descricao, :icone)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':pai_categoria',$pai_categoria);
		$sql->bindValue(':tipo',$tipo);
		$sql->bindValue(':descricao',$descricao);
			$sql->bindValue(':icone',$icone);

		$sql->execute();
		$resp = $sql->rowCount();
		$this->db = null;
		
		return $resp;

	}

	public function update($categoria, $pai_categoria, $tipo, $descricao, $icone){
		
		$sql = "UPDATE categorias SET pai_categoria = :pai_categoria, tipo = :tipo, descricao =  :descricao, icone = :icone where categoria = :categoria";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':categoria',$categoria);
		$sql->bindValue(':pai_categoria',$pai_categoria);
		$sql->bindValue(':tipo',$tipo);
		$sql->bindValue(':descricao',$descricao);
			$sql->bindValue(':icone',$icone);
	
		$sql->execute();
		$resp = $sql->rowCount();

		$this->db = null;

		return $resp;

	}

	public function delete($categoria){

		
		$sql = "DELETE FROM categorias WHERE CATEGORIA = :categoria";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':categoria',$categoria);

		$sql->execute();

		$this->db = null;

		return $sql->rowCount();

	}

}