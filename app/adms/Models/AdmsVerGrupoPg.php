<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerGrupoPg
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVerGrupoPg {

    private $Resultado;
    private $DadosId;

    public function verGrupoPg($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verGrupoPg = new \App\adms\Models\helper\AdmsRead();
        $verGrupoPg->fullRead("SELECT * FROM adms_grps_pgs WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verGrupoPg->getResult();
        return $this->Resultado;
    }

}
