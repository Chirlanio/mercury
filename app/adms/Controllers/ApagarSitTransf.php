<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarSit
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ApagarSitTransf {

    private $DadosId;

    public function apagarSit($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
           $apagarSit = new \App\adms\Models\AdmsApagarSitTransf();
           $apagarSit->apagarSit($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Necessário selecionar uma situação!</div>";
        }
        $UrlDestino = URLADM . 'situacao-transf/listar';
        header("Location: $UrlDestino");
    }

}
