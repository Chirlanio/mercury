<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerSitPg
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVerSitPg {

    private $Resultado;
    private $DadosId;

    public function verSitPg($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verSitPg = new \App\adms\Models\helper\AdmsRead();
        $verSitPg->fullRead("SELECT * FROM adms_sits_pgs WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verSitPg->getResult();
        return $this->Resultado;
    }

}
