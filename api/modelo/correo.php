<?php
function enviarcorreo($Nombre, $Correo){

    try{

        //error_reporting(E_ALL);
        error_reporting(E_STRICT);

        date_default_timezone_set('America/Toronto');

        
    //include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

        $mail             = new PHPMailer();

        $body             = "Buenos dias Julian, No olvides el GETTTTTTTTTTTTTTTT";//file_get_contents('contenidoCorreos.html');
        $body             = eregi_replace("[\]",'',$body);

        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->Host       = "smtp.gmail.com"; // SMTP server
        //$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
        // 1 = errors and messages
        // 2 = messages only
        $mail->SMTPAuth   = true;                  // enable SMTP authentication
        $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
        $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
        $mail->Port       = 465;                   // set the SMTP port for the GMAIL server
        $mail->Username   = "inscripciones@escolme.edu.co";  // GMAIL username
        $mail->Password   = "Esc$2013*";            // GMAIL password

        $mail->SetFrom('inscripciones@escolme.edu.co', 'First Last');

        $mail->AddReplyTo("analista@escolme.edu.co","First Last");

        $mail->Subject    = "Inscripcion Escolme";

        $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

        $mail->MsgHTML($body);

        $address = "analista@escolme.edu.co";
        $mail->AddAddress($address, "Julian");

        //$mail->AddAttachment("images/phpmailer.gif");      // attachment
        //$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

        if(!$mail->Send()) {
            echo '{"Error: ":' . $mail->ErrorInfo . '}';
            
        } else {
            echo '{"Mensaje: ":"Correo Enviado con exito"}';
        }

    }
    catch(Exception $e){
        
    }
   
}