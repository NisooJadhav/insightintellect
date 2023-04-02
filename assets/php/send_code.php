<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

function sendCode($email, $subject, $code)
{
    global $mail;
    echo "<script>alert('$subject')</script>";

    try {
        $mail->SMTPDebug = 1;
        $mail->isSMTP();
        $mail->Host = 'smtp-mail.outlook.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'tusharvagh@outlook.com';
        $mail->Password = 'Tushar@21';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->From = 'tusharvagh@outlook.com';
        $mail->FromName = 'InsightIntellect';
        $mail->setFrom('tusharvagh@outlook.com', 'InsightIntellect');
        $mail->addAddress($email);
        //Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body =
            '<center>
                <div style="width:50vw; height:30vh; padding:20px; background:#eee">
                    <img style="padding:20px" src="https://i.ibb.co/2tbqZHw/logo.png" alt="logo" width="50%" />
                    <h3>OTP for login is: </h3><h1>' . $code . '</h1>
                </div>
            </center>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz'); //Add attachments

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}