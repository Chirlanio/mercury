<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AddCheckList
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meia Sola
 */
class AddCheckList {

    private $Dados;

    public function checkList() {

        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->Dados['AddCheckList'])) {
            unset($this->Dados['AddCheckList']);

            $addCheckList = new \App\adms\Models\AdmsAddCheckList();
            $addCheckList->addCheckList($this->Dados);

            if ($addCheckList->getResultado()) {
                $checkList = new \App\adms\Models\AdmsAddCheckList();
                $checkList->lastId();
                $lastId = $checkList->getResultado();

                $UrlDestino = URLADM . 'edit-check-list/check-list/' . $lastId[0]['id'];
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

        $listarSelect = new \App\adms\Models\AdmsAddCheckList();
        $this->Dados['select'] = $listarSelect->listAdd();

        $botao = ['list_check_list' => ['menu_controller' => 'check-list', 'menu_metodo' => 'list'],
            'add_check_list' => ['menu_controller' => 'add-check-list', 'menu_metodo' => 'check-list'],
            'view_check_list' => ['menu_controller' => 'view-check-list', 'menu_metodo' => 'check-list'],
            'edit_check_list' => ['menu_controller' => 'edit-check-list', 'menu_metodo' => 'check-list'],
            'del_check_list' => ['menu_controller' => 'delete-check-list', 'menu_metodo' => 'check-list']];

        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $carregarView = new \Core\ConfigView("adms/Views/checkList/addCheckList", $this->Dados);
        $carregarView->renderizar();
    }
}
