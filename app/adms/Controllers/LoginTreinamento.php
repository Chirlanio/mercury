<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: login-treinamento/acesso/");
    exit();
}

/**
 * Description of LoginTreinamento
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class LoginTreinamento {

    private $Dados;

    public function acesso() {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['SendLogin'])) {
            unset($this->Dados['SendLogin']);
            $visualLogin = new \App\adms\Models\AdmsLoginTreinamento();
            $visualLogin->acesso($this->Dados);
            if ($visualLogin->getResultado()) {
                $UrlDestino = URLADM . 'home-treinamento/index';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
            }
        }
        $carregarView = new \Core\ConfigView("adms/Views/treinamento/acesso", $this->Dados);
        $carregarView->renderizarLogin();
    }

    public function logout() {
        unset($_SESSION['usuario_id'], $_SESSION['usuario_nome'], $_SESSION['usuario_cpf'], $_SESSION['usuario'], $_SESSION['adms_niveis_acesso_id'], $_SESSION['ordem_nivac'], $_SESSION['nivac_cor'], $_SESSION['adms_sits_usuario_id']);
        $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Deslogado</strong> com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        $UrlDestino = URLADM . 'login-treinamento/acesso';
        header("Location: $UrlDestino");
    }

}
