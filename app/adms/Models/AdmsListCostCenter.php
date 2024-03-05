<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListCostCenter
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListCostCenter {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function list($PageId = null) {
        
        $this->PageId = (int) $PageId;
        
        unset($_SESSION['search']);
        
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'cost-centers/list');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_cost_centers");
        $this->ResultadoPg = $paginacao->getResultado();

        $listCostCenter = new \App\adms\Models\helper\AdmsRead();
        $listCostCenter->fullRead("SELECT cc.id cc_id, cc.cost_center_id, cc.name costCenter, f.name gerencia, a.name name_area, s.nome status FROM adms_cost_centers cc INNER JOIN adms_sits s ON s.id=cc.status_id LEFT JOIN adms_managers f ON f.id=cc.manager_id LEFT JOIN adms_areas a ON a.id=cc.adms_area_id ORDER BY cc.id ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listCostCenter->getResult();
        return $this->Resultado;
    }

}
