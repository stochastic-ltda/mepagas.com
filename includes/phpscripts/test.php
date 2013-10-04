<?php

if (!class_exists('Mailer')) { include( dirname(__FILE__) . '/../classes/Services/Email/Mailer.php'); }

$mail = new Mailer();
$mail->send('pqzada@gmail.com', 'Pablo', 'Hola', '<b>Hola Mundo</b>');

?>