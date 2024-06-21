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
        var_dump($this->Dados);

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

            $this->Dados['new_files'] = ($_FILES['new_files'] ? $_FILES['new_files'] : $this->Dados['file_name']);

            $editCheckList = new \App\adms\Models\AdmsEditCheckList();
            $editCheckList->altCheckList($this->Dados);

            if ($editCheckList->getResultado()) {
                $UrlDestino = URLADM . 'check-list/list';
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

            $botao = ['view_check_list' => ['menu_controller' => 'view-check-list', 'menu_metodo' => 'check-list'],
                'list_check_list' => ['menu_controller' => 'check-list', 'menu_metodo' => 'list']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/checkList/editCheckList", $this->Dados);
            $carregarView->renderizar();
        } else {

            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Solicitação não encontrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'check-list/list';
            header("Location: $UrlDestino");
        }
    }
}
