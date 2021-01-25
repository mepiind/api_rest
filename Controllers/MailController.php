<?php
namespace Controllers;

use \Core\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use \Models\DataBooks;

class MailController extends Controller {

	public function send() {

		$data = $this->getRequestData();
		$email = "Nome: " . $data['nome'] . '<br>';

		if(  isset($data['cidade']) && $data['cidade'] != "" ){
			$email .= "Cidade: " . $data['cidade'] . ' - ' . $data['estado'] . '<br>';
		}

		if(  isset($data['Empresa']) && $data['Empresa'] != "" ){
			$email .= "Empresa: " . $data['empresa'] . '<br>';
		}

		if(  isset($data['celular'])  && $data['celular'] != "" ){
			$email .= "Celular: " . $data['celular']  . '<br>'. '<br>';
		}
		
		$email .= "Assunto: ".  '<br>';
		$email .=  $data['corpo'] . '<br>';
        $mail = new PHPMailer(TRUE);

		try {
    
		    $mail->setFrom('naoresponda@mepi.ind.br', 'APP MEPI');
			$mail->addAddress('mateus.sousa.valente@gmail.com', 'Emperor');
			$mail->Subject = 'CONTATO - APLICATIVO MEPI';
			$mail->Body = $email;
			$mail->IsHTML(true); 
			
			/* SMTP parameters. */
			$mail->IsSMTP(); // enable SMTP
			$mail->SMTPAuth = true;  // authentication enabled
			$mail->SMTPSecure = false; // secure transfer enabled REQUIRED for GMail
			$mail->SMTPAutoTLS = false;
			$mail->Host = 'mail.mepi.ind.br';
			$mail->Port = 587;
			
			/* SMTP authentication username. */
			$mail->Username = 'naoresponda@mepi.ind.br';
			
			/* SMTP authentication password. */
			$mail->Password = 'Ma98kh876*';
			
			if(!$mail->Send()) {
				echo json_encode("error");
			} else {
				echo json_encode("ok");
			}
	
		} catch (Exception $e){
			echo json_encode("error");
		} 
	}

	public function notification() {

		$DataBooks = new DataBooks();
		$databooksClientes = $DataBooks->getDatabooksClienteAll();

		foreach($databooksClientes as $databooksCliente){
			var_dump($databooksCliente['DATABOOK']);
			var_dump($databooksCliente['STATUS']);
			
			if($databooksCliente["STATUS"] == 'AVENCER'){
				
				if($databooksCliente["NOTIFICACAO"] == null){
					$mail = new PHPMailer(TRUE);
					$mail->setFrom('naoresponda@mepi.ind.br', 'APP MEPI');
					$mail->addAddress($databooksCliente['EMAIL'], $databooksCliente['NOME']);
					$mail->addBCC('mateus.valente.act@gmail.com');
					$mail->IsHTML(true);
					$mail->CharSet = "UTF-8";
					$mail->Subject = 'NOTIFICAÇÃO - DATABOOK EXPIRANDO';
					$mail->Body .="<div>Olá " .  $databooksCliente['NOME'] . ",</div></br>"; 
					$mail->Body .="<div> A MEPI informa que a validade do seu equipamento de segurança: "; 
					$mail->Body .="<a href='" . $databooksCliente["DOWNLOAD"]  . "'>" . $databooksCliente["DESCRICAO"] == null ? $databooksCliente["DESCRICAO"] : $databooksCliente["DOWNLOAD"] . "</a>"; 
					$mail->Body .=" vence daqui 30 dias. </div> </br>";
					$mail->Body .="<img width='450px' src='https://ci3.googleusercontent.com/proxy/0u6Rhww0LI5xNhXsaSF1oy-pFSTmhAW2eTUm_UgkkMhF6pCTMexTkzmyPltc5UATnkPBpr44kQXRCxdOZroUICakQ9sUik2UxwwTmzTYFmV36u2O6qd15a9QRBEYp2iqMa658N4sTR_mXlGpW_CZMhJ7oui8voHEHyEoroHQX697=s0-d-e1-ft#https://drive.google.com/a/mepi.ind.br/uc?id=0BwRColEKhwjmZWZRWW9UelExb2xmSHJaQ3pKYnNTSi00YkEw&export=download'>";

					/* SMTP parameters. */
					$mail->IsSMTP(); // enable SMTP
					$mail->SMTPAuth = true;  // authentication enabled
					$mail->SMTPSecure = false; // secure transfer enabled REQUIRED for GMail
					$mail->SMTPAutoTLS = false;
					$mail->Host = 'mail.mepi.ind.br';
					$mail->Port = 587;

					/* SMTP authentication username. */
					$mail->Username = 'naoresponda@mepi.ind.br';

					/* SMTP authentication password. */
					$mail->Password = 'Ma98kh876*';

					if(!$mail->Send()) {
						echo json_encode("error");
					} else {
						echo json_encode("ok");
					}
					$DataBooks->updateNotificacao($databooksCliente['DATABOOK'],'A');
				}
			} else if($databooksCliente["STATUS"] == 'VENCIDO'){
				if($databooksCliente["NOTIFICACAO"] == null ||$databooksCliente["NOTIFICACAO"] == 'A' ){
					$mail = new PHPMailer(TRUE);
					$mail->setFrom('naoresponda@mepi.ind.br', 'APP MEPI');
					$mail->IsHTML(true);
					$mail->addAddress($databooksCliente['EMAIL'], $databooksCliente['NOME']);
					$mail->addBCC('mateus.valente.act@gmail.com');
					$mail->CharSet = "UTF-8";
					$mail->Subject = 'NOTIFICAÇÃO - DATABOOK EXPIRADO';

					$mail->Body .="<div>Olá " .  $databooksCliente['NOME'] . ",</div></br>"; 
					$mail->Body .="<div> A MEPI informa que a validade do seu equipamento de segurança: "; 
					$mail->Body .="<a href='" . $databooksCliente["DOWNLOAD"]  . "'>" . $databooksCliente["DESCRICAO"] == null ? $databooksCliente["DESCRICAO"] : $databooksCliente["DOWNLOAD"] . "</a>"; 
					$mail->Body .=" chegou ao fim. </div> </br>";
					$mail->Body .="<img width='450px' src='https://ci3.googleusercontent.com/proxy/0u6Rhww0LI5xNhXsaSF1oy-pFSTmhAW2eTUm_UgkkMhF6pCTMexTkzmyPltc5UATnkPBpr44kQXRCxdOZroUICakQ9sUik2UxwwTmzTYFmV36u2O6qd15a9QRBEYp2iqMa658N4sTR_mXlGpW_CZMhJ7oui8voHEHyEoroHQX697=s0-d-e1-ft#https://drive.google.com/a/mepi.ind.br/uc?id=0BwRColEKhwjmZWZRWW9UelExb2xmSHJaQ3pKYnNTSi00YkEw&export=download'>";

					/* SMTP parameters. */
					$mail->IsSMTP(); // enable SMTP
					$mail->SMTPAuth = true;  // authentication enabled
					$mail->SMTPSecure = false; // secure transfer enabled REQUIRED for GMail
					$mail->SMTPAutoTLS = false;
					$mail->Host = 'mail.mepi.ind.br';
					$mail->Port = 587;

					/* SMTP authentication username. */
					$mail->Username = 'naoresponda@mepi.ind.br';

					/* SMTP authentication password. */
					$mail->Password = 'Ma98kh876*';

					if(!$mail->Send()) {
						echo json_encode("error");
					} else {
						echo json_encode("ok");
					}
					$DataBooks->updateNotificacao($databooksCliente['DATABOOK'],'V');
				}
			}
		}

		
	}
}