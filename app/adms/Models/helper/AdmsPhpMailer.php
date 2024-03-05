<?php

namespace App\adms\Models\helper;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsPhpMailer
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsPhpMailer {

    private $Resultado;
    private $DadosCredEmail;
    private $Dados;

    function getResultado() {
        return $this->Resultado;
    }

    public function emailPhpMailer(array $Dados) {
        $this->Dados = $Dados;
        $credEmail = new \App\adms\Models\helper\AdmsRead();
        $credEmail->fullRead("SELECT * FROM adms_confs_emails WHERE id =:id LIMIT :limit", "id=1&limit=1");
        $this->DadosCredEmail = $credEmail->getResult();

        if ((isset($this->DadosCredEmail[0]['host'])) AND (!empty($this->DadosCredEmail[0]['host']))) {
            $this->confEmail();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário inserir as credencias do e-mail no administrativo para enviar e-mail!</div>";
            $this->Resultado = false;
        }
    }

    private function confEmail() {
        $phpmailer = new PHPMailer(true);                               // Passing `true` enables exceptions
        try {
            //Server settings
            //$mail->SMTPDebug = 2;                                     // Enable verbose debug output
            $phpmailer->CharSet = 'UTF-8';
            $phpmailer->isSMTP();                                       // Set mailer to use SMTP
            $phpmailer->Host = $this->DadosCredEmail[0]['host'];             // Specify main and backup SMTP servers
            $phpmailer->SMTPAuth = true;                                     // Enable SMTP authentication
            $phpmailer->Username = $this->DadosCredEmail[0]['usuario'];      // SMTP username
            $phpmailer->Password = $this->DadosCredEmail[0]['senha'];        // SMTP password
            $phpmailer->SMTPSecure = $this->DadosCredEmail[0]['smtpsecure']; // Enable TLS encryption, `ssl` also accepted
            $phpmailer->Port = $this->DadosCredEmail[0]['porta'];             // TCP port to connect to


            /* $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
              $phpmailer->SMTPAuth = true;
              $phpmailer->Port = 2525;
              $phpmailer->Username = '987f768ae51cbd';
              $phpmailer->Password = 'ed060abe6c72d9'; */
            //Recipients
            $phpmailer->setFrom($this->DadosCredEmail[0]['email'], $this->DadosCredEmail[0]['nome']);
            $phpmailer->addAddress($this->Dados['dest_email'], $this->Dados['dest_nome']);     // Add a recipient
            //
            //Content
            $phpmailer->isHTML(true);                                  // Set email format to HTML
            $phpmailer->Subject = $this->Dados['titulo_email'];
            $phpmailer->Body = $this->Dados['cont_email'];
            $phpmailer->AltBody = $this->Dados['cont_text_email'];

            if ($phpmailer->send()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>E-mail enviado com sucesso!</div>";
                $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: E-mail não foi enviado com sucesso!</div>";
                $this->Resultado = false;
            }
        } catch (Exception $e) {
            $this->Resultado = false;
        }
    }
}
