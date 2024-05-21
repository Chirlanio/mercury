<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsViewPolicies
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsViewPolicies {

    private $Resultado;
    private $DadosId;

    public function viewPolicie($DadosId) {
        
        $this->DadosId = (int) $DadosId;
        
        $viewPolicie = new \App\adms\Models\helper\AdmsRead();
        $viewPolicie->fullRead("SELECT pl.*, sit.nome nome_sit, cr.cor cor_cr FROM adms_policies pl INNER JOIN adms_sits sit ON sit.id=pl.adms_sit_id INNER JOIN adms_cors cr ON cr.id=sit.adms_cor_id WHERE pl.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $viewPolicie->getResult();
        return $this->Resultado;
    }

}
