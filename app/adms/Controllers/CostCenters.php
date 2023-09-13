<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CostCenters
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CostCenters {

    private $Dados;
    private $PageId;

    public function list($PageId = null) {
        
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_cost' => ['menu_controller' => 'add-cost-center', 'menu_metodo' => 'cost-center'],
            'view_cost' => ['menu_controller' => 'view-cost-center', 'menu_metodo' => 'cost-center'],
            'edit_cost' => ['menu_controller' => 'edit-cost-center', 'menu_metodo' => 'cost-center'],
            'del_cost' => ['menu_controller' => 'delete-cost-center', 'menu_metodo' => 'cost-center']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listCostCenter = new \App\adms\Models\AdmsListCostCenter();
        $this->Dados['listCostCenter'] = $listCostCenter->list($this->PageId);
        $this->Dados['paginacao'] = $listCostCenter->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/costCenter/listCostCenter", $this->Dados);
        $carregarView->renderizar();
    }

}
