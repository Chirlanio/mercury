<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CheckList
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CheckList {

    private $Dados;
    private $PageId;

    public function list($PageId = null) {
        
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['add_check_list' => ['menu_controller' => 'add-check-list', 'menu_metodo' => 'check-list'],
            'view_check_list' => ['menu_controller' => 'view-check-list', 'menu_metodo' => 'check-list'],
            'edit_check_list' => ['menu_controller' => 'edit-check-list', 'menu_metodo' => 'check-list'],
            'del_check_list' => ['menu_controller' => 'delete-check-list', 'menu_metodo' => 'check-list']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listCheckList = new \App\adms\Models\AdmsListCheckList();
        $this->Dados['listCheckList'] = $listCheckList->list($this->PageId);
        $this->Dados['paginacao'] = $listCheckList->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/checkList/listCheckList", $this->Dados);
        $carregarView->renderizar();
    }

}
