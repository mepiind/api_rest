<?php
namespace Models;

use \Core\Model;
use \Models\Jwt;
use PDO;

class Produtos extends Model {

	public function getAll() {
		$array = array();

		$sql = "SELECT P.*, C.DESCRICAO AS MENU_DESC FROM Produtos P JOIN categorias C ON P.categoria = C.categoria ";
		$sql = $this->db->prepare($sql);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll(PDO::FETCH_ASSOC);
		}

		return $array;
	}

	public function getAllCategoria($cagtegoria) {
		$array = array();

		$sql = "SELECT * FROM Produtos WHERE categoria = :cagtegoria";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':cagtegoria',$cagtegoria);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll(PDO::FETCH_ASSOC);
		}

		return $array;
	}

	public function getUnico($produto){
		$data = array();

		$sql = "SELECT P.*, C.DESCRICAO AS MENU_DESC  FROM Produtos P JOIN categorias C ON P.categoria = C.categoria WHERE P.produto = :produto";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':produto',$produto);
		$sql->execute();


		if($sql->rowCount() > 0){
			$data = $sql->fetch(PDO::FETCH_ASSOC);
		} 

		return $data;
	}

	public function insere($categoria,$link_foto,$codigo,$norma,$ca,$marca,$caracteristicas,$descricao,$aplicacao,$informacao,$adicionais, $link_foto_real){
		
		$sql = "INSERT INTO Produtos (categoria, link_foto, codigo, norma, ca, marca, caracteristicas, descricao, aplicacao, informacao, adicionais, link_foto_real) VALUES (:categoria, :link_foto, :codigo, :norma, :ca, :marca, :caracteristicas, :descricao, :aplicacao, :informacao, :adicionais, :link_foto_real)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':categoria',$categoria);
		$sql->bindValue(':link_foto',$link_foto);
		$sql->bindValue(':link_foto_real',$link_foto_real);
		$sql->bindValue(':codigo',$codigo);
		$sql->bindValue(':norma',$norma);
		$sql->bindValue(':ca',$ca);
		$sql->bindValue(':marca',$marca);
		$sql->bindValue(':caracteristicas',$caracteristicas);
		$sql->bindValue(':descricao',$descricao);
		$sql->bindValue(':aplicacao',$aplicacao);
		$sql->bindValue(':informacao',$informacao);
		$sql->bindValue(':adicionais',$adicionais);
		$sql->execute();

		$resp = $sql->rowCount();
		$this->db = null;
		
		return $resp;

	}

	public function update($produto, $categoria,$link_foto,$codigo,$norma,$ca,$marca,$caracteristicas,$descricao,$aplicacao,$informacao,$adicionais){
		
		$sql = "UPDATE Produtos SET categoria = :categoria, norma = :norma, link_foto = :link_foto,codigo = :codigo, ca = :ca, marca = :marca, caracteristicas = :caracteristicas,descricao = :descricao,aplicacao = :aplicacao,informacao = :informacao,adicionais = :adicionais where produto = :produto";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':produto',$produto);
		$sql->bindValue(':categoria',$categoria);
		$sql->bindValue(':link_foto',$link_foto);
		$sql->bindValue(':codigo',$codigo);
		$sql->bindValue(':norma',$norma);
		$sql->bindValue(':ca',$ca);
		$sql->bindValue(':marca',$marca);
		$sql->bindValue(':caracteristicas',$caracteristicas);
		$sql->bindValue(':descricao',$descricao);
		$sql->bindValue(':aplicacao',$aplicacao);
		$sql->bindValue(':informacao',$informacao);
		$sql->bindValue(':adicionais',$adicionais);
	
		$sql->execute();
		$resp = $sql->rowCount();

		$this->db = null;

		return $resp;

	}

	public function delete($produto){
	
		$sql = "DELETE FROM Produtos WHERE produto = :produto";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':produto',$produto);

		$sql->execute();

		$this->db = null;

		return $sql->rowCount();

	}

}