<?php
require 'PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

$mail->SMTPDebug = 2;

$mail->isSMTP();
$mail->Host = 'mailout.one.com';
$mail->SMTPAuth = false;
$mail->Username = 'admin@postpap.de';
$mail->Password = 'admin4postpap';
$mail->SMTPSecure = 'starttls';
$mail->Port = 25;

$mail->setFrom('admin@postpap.de', 'postpap.de');
$mail->addAddress('daniel.oltmanns@outlook.de', 'Daniel');

$mail->isHTML(true);

$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
?>