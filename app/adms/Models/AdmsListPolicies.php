<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListPolicies
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListPolicies {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = LIMIT;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function list($PageId = null) {

        $this->PageId = (int) $PageId;

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'policies/list');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_policies WHERE adms_sit_id =:adms_sit_id", "adms_sit_id=1");
        $this->ResultadoPg = $paginacao->getResultado();

        $listPolicies = new \App\adms\Models\helper\AdmsRead();
        $listPolicies->fullRead("SELECT p.*, st.nome status, co.cor color FROM adms_policies p INNER JOIN adms_sits st ON st.id=p.adms_sit_id INNER JOIN adms_cors co ON co.id=st.adms_cor_id WHERE p.adms_sit_id =:adms_sit_id ORDER BY p.id DESC LIMIT :limit OFFSET :offset", "adms_sit_id=1&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listPolicies->getResult();
        return $this->Resultado;
    }

}
