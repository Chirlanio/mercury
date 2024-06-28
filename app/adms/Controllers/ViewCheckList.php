<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ViewCheckList
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ViewCheckList {

    private $Dados;
    private $DadosId;

    public function checkList(string $DadosId = null) {

        $this->DadosId = $DadosId;

        if (!empty($this->DadosId)) {

            $viewCheckList = new \App\adms\Models\AdmsViewCheckList();
            $this->Dados['dados_check_list'] = $viewCheckList->viewCheckList($this->DadosId);

            $botao = ['list_check_list' => ['menu_controller' => 'check-list', 'menu_metodo' => 'list'],
                'edit_check_list' => ['menu_controller' => 'edit-check-list', 'menu_metodo' => 'check-list'],
                'del_check_list' => ['menu_controller' => 'delete-check-list', 'menu_metodo' => 'check-list']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            
            $listSelect = new \App\adms\Models\AdmsViewCheckList();
            $this->Dados['select'] = $listSelect->listAdd($this->DadosId);

            $carregarView = new \Core\ConfigView("adms/Views/checkList/viewCheckList", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Solicitação não encontrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'check-list/list';
            header("Location: $UrlDestino");
        }
    }
}
