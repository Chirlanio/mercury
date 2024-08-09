<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AddSupplyCheckList
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meia Sola
 */
class AddSupplyCheckList {

    private $Dados;

    public function checkList() {

        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->Dados['AddSupplyCheckList'])) {
            unset($this->Dados['AddSupplyCheckList']);

            $addCheckList = new \App\adms\Models\AdmsAddSupplyCheckList();
            $addCheckList->addCheckList($this->Dados);

            if ($addCheckList->getResultado()) {
                $checkList = new \App\adms\Models\AdmsAddSupplyCheckList();
                $checkList->lastId();
                $lastId = $checkList->getResultado();

                $UrlDestino = URLADM . 'edit-supply-check-list/check-list/' . $lastId[0]['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->addCheckListViewPriv();
            }
        } else {
            $this->addCheckListViewPriv();
        }
    }

    private function addCheckListViewPriv() {

        $listSelect = new \App\adms\Models\AdmsAddSupplyCheckList();
        $this->Dados['select'] = $listSelect->listAdd();

        $botao = ['list_check_list' => ['menu_controller' => 'supply-check-list', 'menu_metodo' => 'list'],
            'add_check_list' => ['menu_controller' => 'add-supply-check-list', 'menu_metodo' => 'check-list'],
            'view_check_list' => ['menu_controller' => 'view-supply-check-list', 'menu_metodo' => 'check-list'],
            'edit_check_list' => ['menu_controller' => 'edit-supply-check-list', 'menu_metodo' => 'check-list'],
            'del_check_list' => ['menu_controller' => 'delete-supply-check-list', 'menu_metodo' => 'check-list']];

        $listButton = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listButton->valBotao($botao);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listMenu->itemMenu();

        $carregarView = new \Core\ConfigView("adms/Views/supplyCheckList/addCheckList", $this->Dados);
        $carregarView->renderizar();
    }
}
