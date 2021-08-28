<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EsqueceuSenha
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EsqueceuSenha
{

    private $Dados;

    public function esqueceuSenha()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['RecupUserLogin'])) {
            $esqSenha = new \App\adms\Models\AdmsEsqueceuSenha();
            $esqSenha->esqueceuSenha($this->Dados);
            if ($esqSenha->getResultado()) {                
                $UrlDestino = URLADM . 'login/acesso';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $carregarView = new \Core\ConfigView("adms/Views/login/esqueceuSenha", $this->Dados);
                $carregarView->renderizarLogin();
            }
        } else {
            $carregarView = new \Core\ConfigView("adms/Views/login/esqueceuSenha", $this->Dados);
            $carregarView->renderizarLogin();
        }
    }

}
