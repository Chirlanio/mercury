<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListCheckList
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListCheckList {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = LIMIT;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function list($PageId = null) {
        
        $this->PageId = (int) $PageId;
        
        unset($_SESSION['search']);
        
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'check-list/list');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_check_lists");
        $this->ResultadoPg = $paginacao->getResultado();

        $listCostCenter = new \App\adms\Models\helper\AdmsRead();
        $listCostCenter->fullRead("SELECT cl.id, cl.adms_store_id, cl.hash_id, cl.responsible_applicator, cl.adms_sit_check_list_id, lj.nome store_name, scl.name_sit, cr.cor cor_cr FROM adms_check_lists cl LEFT JOIN tb_lojas lj ON lj.id = cl.adms_store_id LEFT JOIN adms_sit_check_lists scl ON scl.id = cl.adms_sit_check_list_id LEFT JOIN adms_cors cr On cr.id = scl.adms_cor_id ORDER BY cl.id ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listCostCenter->getResult();
        return $this->Resultado;
    }

}
