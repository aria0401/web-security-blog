<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once(__DIR__ . '/PHPMailer/src/Exception.php');
require_once(__DIR__ . '/PHPMailer/src/PHPMailer.php');
require_once(__DIR__ . '/PHPMailer/src/SMTP.php');


$mail = new PHPMailer(true);

try {

    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'klastuser@gmail.com';
    $mail->Password = 'klastuser4444';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('klastuser@gmail.com');
    $mail->addAddress($_to_email);
    $mail->isHTML(true);
    $mail->Subject = $_subject;
    $mail->Body = $_message;


    $mail->send();

    $sent = true;
} catch (Exception $ex) {
    $user->errors[] = $mail->ErrorInfo;
}
