<?php
namespace Models;

use \Core\Model;
use \Models\Jwt;

class Clientes extends Model {

	public function getAll() {
		$array = array();

		$sql = "SELECT * FROM CLIENTES";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}

	public function getUnico($cliente){
		$data = array();
		
		$sql = "SELECT * FROM CLIENTES WHERE cliente = :cliente";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':cliente',$cliente);
		$sql->execute();

		if($sql->rowCount() > 0){
			$data = $sql->fetch();
		} 

		return $data;
	}

	public function insere($usuario, $senha, $cnpj, $telefone, $celular, $cidade, $endereco, $estado, $cep, $email, $site, $nome){
		
		$sql = "INSERT INTO CLIENTES (nome,usuario, senha, cnpj, telefone, celular, cidade, endereco, estado, cep, email, site) VALUES (:nome,:usuario, :senha, :cnpj, :telefone, :celular, :cidade, :endereco, :estado, :cep, :email, :site)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':usuario',$usuario);
		$sql->bindValue(':senha',$senha);
		$sql->bindValue(':cnpj',$cnpj);
		$sql->bindValue(':celular',$celular);
		$sql->bindValue(':telefone',$telefone);
		$sql->bindValue(':cidade',$cidade);
		$sql->bindValue(':endereco',$endereco);
		$sql->bindValue(':estado',$estado);
		$sql->bindValue(':cep',$cep);
		$sql->bindValue(':email',$email);
		$sql->bindValue(':site',$site);
		$sql->bindValue(':nome',$nome);


		$sql->execute();
		$resp = $sql->rowCount();
		$this->db = null;
		
		return $resp;
	}

	public function update($cliente, $usuario, $senha, $cnpj, $telefone, $celular, $cidade, $endereco, $estado, $cep, $nome){
		
		$sql = "UPDATE CLIENTES SET usuario = :usuario, senha = :senha, cnpj =  :cnpj, celular = :celular, telefone = :telefone, cidade = :cidade, endereco = :endereco, estado = :estado, cep = :cep, email = :email , site = :site, nome = :nome where cliente = :cliente";
		$sql->bindValue(':cliente',$cliente);
		$sql->bindValue(':usuario',$usuario);
		$sql->bindValue(':senha',$senha);
		$sql->bindValue(':cnpj',$cnpj);
		$sql->bindValue(':celular',$celular);
		$sql->bindValue(':telefone',$telefone);
		$sql->bindValue(':cidade',$cidade);
		$sql->bindValue(':endereco',$endereco);
		$sql->bindValue(':estado',$estado);
		$sql->bindValue(':cep',$cep);
		$sql->bindValue(':email',$email);
		$sql->bindValue(':site',$site);
		$sql->bindValue(':nome',$nome);
	
		$sql->execute();
		$resp = $sql->rowCount();

		$this->db = null;

		return $resp;

	}

	public function delete($cliente){
	
		$sql = "DELETE FROM CLIENTES WHERE cliente = :cliente";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':categoria',$cliente);

		$sql->execute();

		$this->db = null;

		return $sql->rowCount();

	}

}