<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarCargo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ApagarCargo {

    private $DadosId;

    public function apagarCargo($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $apagarCargo = new \App\adms\Models\AdmsApagarCargo();
            $apagarCargo->apagarCargo($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar um cargo!</div>";
        }
        $UrlDestino = URLADM . 'cargo/listarCargo';
        header("Location: $UrlDestino");
    }

}
