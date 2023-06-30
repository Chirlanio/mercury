<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerCfop
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVerCfop {

    private $Resultado;
    private $DadosId;

    public function verCfop($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verCfop = new \App\adms\Models\helper\AdmsRead();
        $verCfop->fullRead("SELECT * FROM adms_cfops 
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verCfop->getResultado();
        return $this->Resultado;
    }

}
