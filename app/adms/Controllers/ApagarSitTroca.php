<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarSitTroca
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ApagarSitTroca {

    private $DadosId;

    public function apagarSit($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $apagarSit = new \App\adms\Models\AdmsApagarSitTroca();
            $apagarSit->apagarSit($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar uma situação!</div>";
        }
        $UrlDestino = URLADM . 'situacao-troca/listar';
        header("Location: $UrlDestino");
    }

}
