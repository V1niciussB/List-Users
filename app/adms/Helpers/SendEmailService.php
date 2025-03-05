<?php 

namespace App\Adms\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class SendEmailService
{

    public static function sendEmail(string $email, string $name, string $subject, string $body, string $altBody):bool
    {

        $mail = new PHPMailer(true);

        try{

            // $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail-> Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '3878bcab20d5e5';
            $mail->Password = '0b44e25bf5b726';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            

            $mail->setFrom('viniciusbarbosaa03@gmail.com', 'ADM Zero Bugs');
            $mail->addAddress($email, $name);

            $mail->CharSet = 'UTF-8';
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AltBody = $altBody;

            $mail->send();
            GenerateLog::generateLog("error", "E-mail enviado", ['email' => $email, 'subject' => $subject]);


            return true;

        }catch (Exception $e){
            GenerateLog::generateLog("error", "E-mail não enviado", ['email' => $email, 'error' => $e->getMessage()]);


            return false;
        }

    }


}