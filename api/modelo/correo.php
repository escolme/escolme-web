<?php
function enviarcorreo($address,$Nombre){

    try{

        //error_reporting(E_ALL);
        error_reporting(E_STRICT);

        date_default_timezone_set('America/Toronto');

        
    //include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

        $mail             = new PHPMailer();

        $body             = "<html><body style='width:650px;' ><img src='http://www.escolme.edu.co/sicaes/img/headerpgsica2.png' style='width:100%;'> </img> <br> <h1>Inscripción Correcta</h1> <p> <?php echo ($Nombre); ?> Recuerda entregar la documentación en la oficina de Admisiones y Registro y continuar con el proceso.</p> </body></html>";
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
        //$mail->Username   = "jsancheza028@escolme.edu.co";  // GMAIL username
        //$mail->Password   = "david1040734935";            // GMAIL password

        $mail->SetFrom('inscripciones@escolme.edu.co', 'Institucion Universitaria Escolme');

        //$mail->AddReplyTo("analista@escolme.edu.co","First Last");

        $mail->Subject    = "Inscripcion Escolme";

        $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

        $mail->MsgHTML($body);

        //$address = $Correo;
        $mail->AddAddress($address, "Aspirante");

        //$mail->AddAttachment("images/phpmailer.gif");      // attachment
        //$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

        if(!$mail->Send()) {
            echo '{"Error: ":' . $mail->ErrorInfo . '}';
            
        } else {
            echo '{"Mensaje: ":"Correo Enviado con exito"' .$Nombre. '}';
            //echo utf8_encode('{"Mensaje": ' . json_encode($address." ".$Nombre) . '}');
        }

    }
    catch(Exception $e){
        
    }
   
}