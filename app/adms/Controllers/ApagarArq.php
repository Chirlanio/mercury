<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarUsuario
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ApagarArq {

    private $DadosId;

    public function apagarArq($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $apagarArq = new \App\adms\Models\AdmsApagarArq();
            $apagarArq->apagarArq($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar um arquivo!</div>";
        }
        $UrlDestino = URLADM . 'listar-arquivo/listar';
        header("Location: $UrlDestino");
    }

}
