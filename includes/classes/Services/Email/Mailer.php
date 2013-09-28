<?php
include( dirname(__FILE__) . '/../../../vendor/autoload.php');

class Mailer {

	protected $_mail;

	function __construct() {

		$this->_mail = new PHPMailer();

		$this->_mail->IsSMTP();
		$this->_mail->Host = "smtp.mailgun.org";  // specify main and backup server
		$this->_mail->Port = 465; 
		$this->_mail->SMTPAuth = true;     // turn on SMTP authentication
		$this->_mail->SMTPSecure = 'ssl';
		$this->_mail->Username = "postmaster@mepagas.com";  // SMTP username
		$this->_mail->Password = "43x-wrgrvdn9"; // SMTP password
		$this->_mail->From = "postmaster@mepagas.com";
		$this->_mail->FromName = "Mepagas.com";

		$this->_mail->IsHTML(true); 

	}

	function send($to, $name, $subject, $body) {

		$this->_mail->AddAddress($to, $name);
		$this->_mail->Subject = $subject;
		$this->_mail->Body    = $body;

		return $this->_mail->Send();

	}

		
//if(!$mail->Send()) {
	//echo "Mailer Error: " . $mail->ErrorInfo;
//} 

}

?>