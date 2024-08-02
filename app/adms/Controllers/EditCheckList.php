<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditCheckList
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meia Sola
 */
class EditCheckList {

    private $Dados;
    private $DadosId;

    public function checkList($DadosId = null) {

        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->Dados['file_name'] = (isset($_FILES['file_name']) AND !empty($_FILES['file_name'])) ? $_FILES['file_name'] : "";

        $this->DadosId = (string) $DadosId;

        if (!empty($this->DadosId)) {
            $this->editCheckListPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Registro não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'check-list/list';
            header("Location: $UrlDestino");
        }
    }

    private function editCheckListPriv() {
        if (!empty($this->Dados['EditCheckList'])) {
            unset($this->Dados['EditCheckList']);

            $editCheckList = new \App\adms\Models\AdmsEditCheckList();
            $editCheckList->altCheckList($this->Dados);

            if ($editCheckList->getResultado()) {
                $UrlDestino = URLADM . 'edit-check-list/check-list/' . $this->DadosId;
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editCheckListViewPriv();
            }
        } else {
            $viewCheckList = new \App\adms\Models\AdmsEditCheckList();
            $this->Dados['form'] = $viewCheckList->viewCheckList($this->DadosId);
            $this->editCheckListViewPriv();
        }
    }

    private function editCheckListViewPriv() {
        if ($this->Dados['form']) {

            $listarSelect = new \App\adms\Models\AdmsEditCheckList();
            $this->Dados['select'] = $listarSelect->listAdd();

            $botao = ['view_check_list' => ['menu_controller' => 'view-check-list', 'menu_metodo' => 'check-list'], 'list_check_list' => ['menu_controller' => 'check-list', 'menu_metodo' => 'list']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/checkList/editCheckList", $this->Dados);
            $carregarView->renderizar();
        } else {
            $UrlDestino = URLADM . 'check-list/list';
            if ($this->Dados['select']['countHashNoResp'][0]['no_resp_result'] == 0) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Check List</strong> finalizado com exito!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                header("Location: $UrlDestino");
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Solicitação não encontrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                header("Location: $UrlDestino");
            }
        }
    }
}
