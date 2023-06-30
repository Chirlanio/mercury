<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of NovoUsuario
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class NovoUsuario
{

    private $Dados;

    public function novoUsuario()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadUserLogin'])) {
            unset($this->Dados['CadUserLogin']);
            $cadUser = new \App\adms\Models\AdmsNovoUsuario();
            $cadUser->cadUser($this->Dados);
            if ($cadUser->getResultado()) {
                $UrlDestino = URLADM . 'login/acesso';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $carregarView = new \Core\ConfigView("adms/Views/login/novoUsuario", $this->Dados);
                $carregarView->renderizarLogin();
            }
        } else {
            $carregarView = new \Core\ConfigView("adms/Views/login/novoUsuario", $this->Dados);
            $carregarView->renderizarLogin();
        }
    }

}
