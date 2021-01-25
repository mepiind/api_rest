<?php
namespace Models;

use \Core\Model;
use \Models\Jwt;

class Catalogos extends Model {

	public function getAll() {
		$array = array();

		$sql = "SELECT c.*, '' as PRODUTOS FROM catalogos c ORDER BY DATA DESC";
    	$sql = $this->db->prepare($sql);
    	$sql->execute();
       
    
		if($sql->rowCount() ){
			$array = $sql->fetchAll();
		}

		return $array;
	}
	
	public function getCatalgosProdutos($catalogo){
	    $data = array();
	    

		$sql = "SELECT * FROM catalogos_produtos cp join Produtos p on cp.PRODUTO = p.PRODUTO WHERE catalogo = :catalogo";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':catalogo',$catalogo);
		$sql->execute();

		if($sql->rowCount() > 0){
			$data = $sql->fetchAll();
		} 

		return $data;
	}
	
	public function getUnico($catalogo){
		$data = array();
		
		$sql = "SELECT * FROM catalogos WHERE catalogo = :catalogo";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':catalogo',$catalogo);
		$sql->execute();

		if($sql->rowCount() > 0){
			$data = $sql->fetch();
		} 

		return $data;
	}
	
	public function deletaProdutos($catalogo){
	    

	    if($this->db == null){
			$this->redoConnection();
		}
	    
	 
	    
		$sql = "DELETE FROM catalogos_produtos WHERE catalogo = :catalogo";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':catalogo',$catalogo);

		$sql->execute();

		$this->db = null;
	    

		return $sql->rowCount();
	}

	public function insere($iframe,  $link_img, $titulo){
		
		$sql = "INSERT INTO catalogos (iframe,titulo, link_img, data) VALUES (:iframe, :titulo, :link_img, SYSDATE())";
		
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':iframe',$iframe);
		$sql->bindValue(':link_img',$link_img);
		$sql->bindValue(':titulo',$titulo);

		$sql->execute();
		
		if($sql->rowCount() > 0){
			$resp = $this->db->lastInsertId();
		}
		$this->db = null;
		
		return $resp;

	}
	
	public function insereProdutos($produto, $catalogo){
		
		if($this->db == null){
			$this->redoConnection();
		}
		
		$sql = "INSERT INTO catalogos_produtos (produto, catalogo) VALUES (:catalogo, :produto)";
		
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':produto',$produto);
		$sql->bindValue(':catalogo',$catalogo);

		$sql->execute();
		
		if($sql->rowCount() > 0){
			$resp = $this->db->lastInsertId();
		}
		$this->db = null;
		
		return $resp;

	}
	
	public function getAllProdutosCatalogos($catalogo) {
		$array = array();

		$sql = "SELECT * FROM catalogos_produtos where catalogo = :catalogo";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':catalogo',$catalogo);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}
	

	public function update($catalogo, $iframe, $link_img, $titulo){
		
	
	    
	     
            $sql = "UPDATE catalogos SET iframe = :iframe, titulo =  :titulo,  link_img =  :link_img where catalogo = :catalogo";
    		$sql = $this->db->prepare($sql);
    		$sql->bindValue(':catalogo',$catalogo);
    		$sql->bindValue(':iframe',$iframe);
    		$sql->bindValue(':link_img',$link_img);
    		$sql->bindValue(':titulo',$titulo);
    		$sql->execute();
    		$resp = $sql->rowCount();
    
    		$this->db = null;
    		
    		 
        
        
	    
	

		return $resp;

	}

	public function delete($catalogo){
	    
	    $this->deletaProdutos($catalogo);
	    
	    if($this->db == null){
			$this->redoConnection();
		}
		
	    
		$sql = "DELETE FROM catalogos WHERE catalogo = :catalogo";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':catalogo',$catalogo);

		$sql->execute();

		$this->db = null;

		return $sql->rowCount();

	}

	
}