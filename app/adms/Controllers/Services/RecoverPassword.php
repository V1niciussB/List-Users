<?php

namespace App\Adms\Controllers\Services;

use App\Adms\Helpers\SendEmailService;
use App\Adms\Models\Repository\ResetPasswordRepository;

class RecoverPassword
{

    public function recoverPassword(array $data): bool
    {
        // Instanciar o serviço para gerar a chave
        $valueGenerateKey = GenerateKeyService::generateKey();

        $data['key'] = $valueGenerateKey['key'];
        $data['recover_password'] = $valueGenerateKey['encryptedKey'];
        $data['validate_recover_password'] = date("Y-m-d H:i:s", strtotime('+1hour'));
        // Formata a data e a hora separadamente
        $formattedTime = date("H:i:s", strtotime($data['validate_recover_password']));
        $formattedDate = date("d/m/Y", strtotime($data['validate_recover_password']));

        // Atualizar o usuário
        $userUpdate = new ResetPasswordRepository();
        $result = $userUpdate->updateForgotPassword($data);

        // // Acessa o IF se o repository retornou TRUE
        if (!$result) {
            return false;
        }

        $name = explode(" ", $data['user']['name']);
        $firstName = $name[0];

        $subject = "Recuperar Senha";
        $url = "{$_ENV['URL_ADM']}reset-password/{$data['key']}";

        $body = "<p> Prezado (a) $firstName </p>";
        $body .= "<p> Você solicitou alteração de senha. </p>";
        $body .= "<p> Para continuar o processo de recuperação de sua senha, clique no link abaixo ou cole o endereço no seu navegador: </p>";
        $body .= "<p><a href='$url'> $url </a> </p>";
        $body .= "<p> Por questões de segurança esse código é válido somente até as $formattedTime do dia $formattedDate. Caso esse prazo esteja expirado, será necessário solicitar outro códgio. </p>";
        $body .= "<p> Se você não solicitou essa alteração, nenhuma ação é necessária. Sua senha permanecerá a mesma até que vocÊ ative este código. </p>";

        $altBody = "Prezado (a) $firstName \n\n";
        $altBody .= "Você solicitou alteração de senha. \n\n";
        $altBody .= "Para continuar o processo de recuperação de sua senha, clique no link abaixo ou cole o endereço no seu navegador: \n\n";
        $altBody .= "$url \n\n";
        $altBody .= "Por questões de segurança esse código é válido somente até as $formattedTime do dia $formattedDate. Caso esse prazo esteja expirado, será necessário solicitar outro códgio. \n\n";
        $altBody .= "Se você não solicitou essa alteração, nenhuma ação é necessária. Sua senha permanecerá a mesma até que vocÊ ative este código. \n\n";

        $sendEmail = new SendEmailService();
        $resultSendEmail = $sendEmail->sendEmail($data['user']['email'], $data['user']['name'], $subject, $body, $altBody);

        return $resultSendEmail;
    }

}