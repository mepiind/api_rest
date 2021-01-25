<?php
namespace Models;

use \Core\Model;
use \Models\Jwt;
use PDO;

class Clientes extends Model {

	public function getAll() {
		$array = array();

		

		$sql = "SELECT CLIENTE, NOME, TELEFONE, EMAIL, CIDADE, ESTADO FROM Clientes";


		$sql = $this->db->query($sql);

	
		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		
		}

		return $array;
	}

	public function getUnico($cliente){
		$data = array();
		$sql = "SELECT * FROM Clientes WHERE cliente = :cliente";
		
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':cliente',$cliente);
		$sql->execute();
		
		if($sql->rowCount() > 0){
			$data = $sql->fetch(PDO::FETCH_ASSOC);
		} 

		return $data;
	}

	public function insere($usuario, $senha, $cpf, $telefone, $celular, $cidade, $endereco, $estado, $cep, $email, $site, $nome){
		
		$sql = "INSERT INTO Clientes (nome,usuario, senha, cpf, telefone, celular, cidade, endereco, estado, cep, email, site) VALUES (:nome,:usuario, :senha, :cpf, :telefone, :celular, :cidade, :endereco, :estado, :cep, :email, :site)";
		$sql = $this->db->prepare($sql);

		$sql->bindValue(':usuario',$usuario);
		$sql->bindValue(':senha',$senha);
		$sql->bindValue(':cpf',$cpf);
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

	public function update($cliente, $usuario, $senha, $cpf, $telefone, $celular, $cidade, $endereco, $estado, $cep, $email, $site, $nome){
		
		$sql = "UPDATE Clientes SET usuario = :usuario, senha = :senha, cpf =  :cpf, celular = :celular, telefone = :telefone, cidade = :cidade, endereco = :endereco, estado = :estado, cep = :cep, email = :email , site = :site, nome = :nome where cliente = :cliente";
		$sql = $this->db->prepare($sql);

		$sql->bindValue(':cliente',$cliente);
		$sql->bindValue(':usuario',$usuario);
		$sql->bindValue(':senha',$senha);
		$sql->bindValue(':cpf',$cpf);
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
	
		$sql = "DELETE FROM Clientes WHERE cliente = :cliente";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':cliente',$cliente);

		$sql->execute();

		$this->db = null;

		return $sql->rowCount();

	}

}