<?php
class Conexao
{    
    private $_host = 'localhost';
    private $_username = 'mepiind_std_app';
    private $_password = 'A8*eivsdCH0F';
    private $_database = 'mepiind_aplicativo';
    
    public $connection;
    
    public function __construct()
    {
        if (!isset($this->connection)) {
            
            $this->connection = new PDO("mysql:host=" . $this->_host .";dbname=". $this->_database , $this->_username, $this->_password );
            
            if (!$this->connection) {
                echo 'Não foi possível conectar ao banco';
                exit;
            }            
        }    
        
        
    }
    
    public function executeSelect($query)
    {        
         if (!$query->execute()) {
	
	   var_dump($query->errorInfo());
	}
                     
        $rows = array();
        
        
        while($row = $query->fetch(PDO::FETCH_OBJ)) {
            $rows[] = $row;
        }
        
        return $rows;
    }

    public function executeInsertUpadte($query)
    {        
        
        if (!$query->execute()) {
	
	   var_dump($query->errorInfo());
	}
	
	$AfectedRows = $query->rowCount();
	       
        return  $AfectedRows;
                       
    }
}
?>