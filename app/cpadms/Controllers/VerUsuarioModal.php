<?php

namespace App\cpadms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of VerUsuarioModal
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class VerUsuarioModal {

    private $Dados;
    private $DadosId;

    public function verUsuario($DadosId = null) {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verUsuario = new \App\adms\Models\AdmsVerUsuario();
            $this->Dados['dados_usuario'] = $verUsuario->verUsuario($this->DadosId);

            $carregarView = new \App\cpadms\core\ConfigView("cpadms/Views/usuario/verUsuarioModal", $this->Dados);
            $carregarView->renderizarListar();
        }
    }

}
