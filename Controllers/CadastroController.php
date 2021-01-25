<?php
namespace Controllers;

use \Core\Controller;

class CadastroController extends Controller {

	public function index($index) {

		$file = fopen( (__DIR__) ."/files/ca.txt","r");

		$cont = 0;

		$ArrayKey = array();
		$ArrayList =[];
		$indexPrincipal;

		while(!feof($file)){
			
			$content = explode("|",utf8_encode(fgets($file)));

			if($cont==0){
				foreach($content as $key => $contentIndex){
					$ArrayKey[$key] = $contentIndex;
					if($contentIndex == '#NRRegistroCA'){
						$indexPrincipal = $key;
					}
				}
			} else {

				$ArrayAux = array();

				foreach($content as $key => $co){
					$ArrayAux[$ArrayKey[$key]] = $co; 
				}

				if($content[$indexPrincipal] == $index){
					$ArrayList = $ArrayAux;
				}

				
			}
			$cont++;
		}
		$this->returnJson($ArrayList);
	}
}