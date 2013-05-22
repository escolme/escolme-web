<?php
function EnviarCorreo(){

    //agregamos la dependencia de Swift Mailer
    require_once 'api/Swift-5.0.0/lib/swift_required.php';
    //configuracion de la cuenta
    $objCuentaUtilizada=Array(
    'smtp'=>'smtp.gmail.com',//direccion del smtp
    'puerto'=>465,//puerto smtp
    'nombre'=>'ESCOLME',//nombre que aparecera en los correos
    'cuenta'=>'analista@escolme.edu.co',//cuenta que vamos a usar (colocar con @)
    'usuario'=>'analista@escolme.edu.co',//usuario de smtp
    'contrasena'=>'david1040734935'//contrasena de smtp
    );

     //creamos el nuevo transporte de Swift con los datos de conexion
    $objTransporte=Swift_SmtpTransport::newInstance($objCuentaUtilizada['smtp'],
    $objCuentaUtilizada['puerto'])
    ->setUsername($objCuentaUtilizada['usuario'])//le indicamos el usuario smtp que vamos a usar
    ->setPassword($objCuentaUtilizada['contrasena'])//contrasena del usuario smtp
    ;

    //instanciamos el mailer con los datos de conexion establecidos anteriormente
    $objMailer=Swift_Mailer::newInstance($objTransporte);
    //creamos el mensaje
    $objMensaje=Swift_Message::newInstance('Inscripcion')//asunto del mensaje
    ->setFrom(array($objCuentaUtilizada['cuenta'] => $objCuentaUtilizada['nombre']))//quien esta enviando el mensaje?
    ->setTo(array('jsancheza028@escolme.edu.co' => 'Aspirante'))//a quien le enviamos el mensaje?
    ->setBody('<h1>Hola mundo!</h1><p>Prueba de lewebmonster.com</p>') //cuerpo del mensaje   
    ->setContentType('text/html')//mensaje en formato HTML
        ;
    //enviamos el mensaje
    if($objMailer->send($objMensaje)){
    echo 'El mensaje se envi&oacute; correctamente!';
    }else{
    echo 'El mensaje no fue enviado!';
    }

}


/*    $mail='analista@escolme.edu.co';


    $nombre = $_POST['Escolme'];
    $email = $_POST['jsancheza028@escolme.edu.co'];
    $msg = $_POST['Gracias por Inscribirte'];

    //$thank="index.html";

    $message = "
    nombre:".$nombre."
    email:".$email."
    msg:".$msg."";

    if (mail($mail,"consulta",$message))
        echo("Mensaje enviado correctamente");
    else
        echo("No se envio el correo");
        //Header ("Location: $thank");*/
/*    if(mail('analista@escolme.edu.co','Hola, esta es una prueba','Mi mensaje va en este espacio!')){
    echo ('Su mensaje fue enviado!');
}else{
    echo ('Su mensaje no se pudo enviar!');*/