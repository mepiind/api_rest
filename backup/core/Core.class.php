<?php

class Core {
  public function run() {
      
      header('Content-Type: application/json; charset=UTF-8');
		
		$retorno = new stdClass();
		$resultado = new stdClass();
		$obj = new stdClass();
		
		$obj = json_decode( file_get_contents("php://input"));
		
		
        
        /*if(isset($_POST['classe'])){
            

            $obj->classe = isset($_POST['classe'])?$_POST['classe']:null;
    		$obj->metodo = isset($_POST['metodo'])?$_POST['metodo']:null;
    		$obj->parametros = isset($_POST['parametros'])?$_POST['parametros']:null;
    		$obj->token = isset($_POST['token '])?$_POST['token ']:null;
            
        } elseif(isset($_GET['classe'])) {
            


            $obj->classe = isset($_GET['classe'])?$_GET['classe']:null;
    		$obj->metodo = isset($_GET['metodo'])?$_GET['metodo']:null;
    		$obj->parametros = isset($_GET['parametros'])?$_GET['parametros']:null;
    		$obj->token = isset($_GET['token '])?$_GET['token ']:null;
            
        }*/
        

        
        if($obj == null) {
            echo 'nnenhum parametro foi passado';
        } else {
            

           $class = new $obj->classe();
           
           
    		if (method_exists($class, $obj->metodo))
    		{
    				
    				
    		    $reflect = new ReflectionMethod($class, $obj->metodo);
			    if($obj->parametros!=null){
			    	$resultado = $reflect->invokeArgs($class, $obj->parametros);
			    }else{
			    	$resultado = $reflect->invoke($class);
			    }
				
    					
				if ($resultado) {
					$json = json_encode($resultado);
				} else {
					$json = json_encode('error_vazio');
				}
				

				echo $json;
    				 
    			
    		}
    		else
    		{
    			throw new Exception("A classe ou o método não existe");
    		}

            
        }
		
		
		
		
		
      
  }
   
}

?>
