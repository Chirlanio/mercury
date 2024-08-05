<?php

namespace App\cpadms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of SearchCheckList
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class SearchCheckList {

    private $Dados;
    private $DadosForm;
    private $PageId;

    public function list($PageId = null) {

        $buttonView = ['check_list' => ['menu_controller' => 'check-list', 'menu_metodo' => 'list'], 'add_check_list' => ['menu_controller' => 'add-check-list', 'menu_metodo' => 'check-list'], 'view_check_list' => ['menu_controller' => 'view-check-list', 'menu_metodo' => 'check-list'], 'edit_check_list' => ['menu_controller' => 'edit-check-list', 'menu_metodo' => 'check-list'], 'del_check_list' => ['menu_controller' => 'delete-check-list', 'menu_metodo' => 'check-list']];
        $listButton = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listButton->valBotao($buttonView);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listMenu->itemMenu();

        $this->DadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($this->DadosForm['SearchCheckList'])) {
            unset($this->DadosForm['SearchCheckList']);
        } else {
            $this->PageId = (int) $PageId ? $PageId : 1;
            $this->DadosForm['search'] = filter_input(INPUT_GET, 'search', FILTER_DEFAULT);
        }

        $listCheckList = new \App\cpadms\Models\CpAdmsSearchCheckList();
        $this->Dados['data_check_list'] = $listCheckList->list($this->PageId, $this->DadosForm);
        $this->Dados['paginacao'] = $listCheckList->getResultado();

        $carregarView = new \Core\ConfigView("cpadms/Views/checkList/searchCheckList", $this->Dados);
        $carregarView->renderizar();
    }

}
