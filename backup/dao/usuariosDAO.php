
<?


class  usuariosDAO {
    
    protected function teste(){
	    $conexao = new Conexao();
            $query = $conexao->connection->prepare("SELECT * FROM usuarios");
      	   
      	    
      	   // $query->bindValue( ":USUARIO", $usuario);
      	   // $query->bindValue( ":SENHA", $senha);
      	    
      	    return $retorno = $conexao->executeSelect($query);
                   

	}
    
}

?>