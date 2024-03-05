<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsViewCostCenter
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsViewCostCenter {

    private $Resultado;
    private $DadosId;

    public function costCenter($DadosId) {
        $this->DadosId = (int) $DadosId;
        $viewCostCenter = new \App\adms\Models\helper\AdmsRead();
        $viewCostCenter->fullRead("SELECT cc.id cc_id, cc.cost_center_id, cc.name costCenter, f.nome gerencia, s.nome status, cc.created, cc.modified FROM adms_cost_centers cc INNER JOIN adms_sits s ON s.id=cc.status_id LEFT JOIN tb_funcionarios f ON f.id=cc.manager_id WHERE cc.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $viewCostCenter->getResult();
        return $this->Resultado;
    }

}
