<?php
namespace Models;

use \Core\Model;
use \Models\Jwt;

class Noticias extends Model {

	public function getAll() {
		$array = array();

		$sql = "SELECT * FROM Noticias ORDER BY DT_NOTICIA DESC";
    	$sql = $this->db->prepare($sql);
    	$sql->execute();
       
    
		if($sql->rowCount() ){
			$array = $sql->fetchAll();
		}

		return $array;
	}
	
	public function getUnico($noticia){
		$data = array();
		
		$sql = "SELECT * FROM Noticias WHERE noticia = :noticia";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':noticia',$noticia);
		$sql->execute();

		if($sql->rowCount() > 0){
			$data = $sql->fetch();
		} 

		return $data;
	}

	public function insere($descricao, $descricao_reduz, $link_img, $titulo){
		
		$sql = "INSERT INTO Noticias (descricao, descricao_reduz, titulo, link_img, dt_noticia) VALUES (:descricao, :descricao_reduz, :titulo, :link_img, SYSDATE())";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':descricao',$descricao);
		$sql->bindValue(':descricao_reduz',$descricao_reduz);
		$sql->bindValue(':link_img',$link_img);
		$sql->bindValue(':titulo',$titulo);

		$sql->execute();
		$resp = $sql->rowCount();
		$this->db = null;
		
		return $resp;

	}

	public function update($noticia, $descricao, $descricao_reduz, $link_img, $titulo){
		
		$sql = "UPDATE Noticias SET noticia = :noticia, descricao = :descricao, titulo =  :titulo,  link_img =  :link_img, descricao_reduz = :descricao_reduz where noticia = :noticia";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':noticia',$noticia);
		$sql->bindValue(':descricao',$descricao);
		$sql->bindValue(':descricao_reduz',$descricao_reduz);
		$sql->bindValue(':link_img',$link_img);
		$sql->bindValue(':titulo',$titulo);
	
		$sql->execute();
		$resp = $sql->rowCount();

		$this->db = null;

		return $resp;

	}

	public function delete($noticia){
	
		$sql = "DELETE FROM Noticias WHERE NOTICIA = :noticia";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':noticia',$noticia);

		$sql->execute();

		$this->db = null;

		return $sql->rowCount();

	}

	
}