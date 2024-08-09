<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of SupplyCheckList
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class SupplyCheckList {

    private $Dados;
    private $PageId;

    public function list($PageId = null) {
        
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['add_supply_check' => ['menu_controller' => 'add-supply-check-list', 'menu_metodo' => 'check-list'],
            'view_supply_check' => ['menu_controller' => 'view-supply-check-list', 'menu_metodo' => 'check-list'],
            'edit_supply_check' => ['menu_controller' => 'edit-supply-check-list', 'menu_metodo' => 'check-list'],
            'del_supply_check' => ['menu_controller' => 'delete-supply-check-list', 'menu_metodo' => 'check-list']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listCheckList = new \App\adms\Models\AdmsSupplyCheckList();
        $this->Dados['listCheckList'] = $listCheckList->list($this->PageId);
        $this->Dados['paginacao'] = $listCheckList->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/supplyCheckList/listCheckList", $this->Dados);
        $carregarView->renderizar();
    }

}
