<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerSitTroca
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVerSitTroca {

    private $Resultado;
    private $DadosId;

    public function verSit($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verSit = new \App\adms\Models\helper\AdmsRead();
        $verSit->fullRead("SELECT sit.*, cr.cor cor_cr, cr.nome cor FROM tb_status_troca sit INNER JOIN adms_cors cr ON cr.id=sit.adms_cor_id WHERE sit.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verSit->getResult();
        return $this->Resultado;
    }

}
