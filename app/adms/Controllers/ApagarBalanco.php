<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarBalanco
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ApagarBalanco {

    private $DadosId;

    public function apagarBalanco($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $apagarBalanco = new \App\adms\Models\AdmsApagarBalanco();
            $apagarBalanco->apagarBalanco($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar um registro!</div>";
        }
        $UrlDestino = URLADM . 'balanco/listar';
        header("Location: $UrlDestino");
    }

}
