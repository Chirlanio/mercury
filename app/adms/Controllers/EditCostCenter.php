<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditCostCenter
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditCostCenter {

    private $Dados;
    private $DadosId;

    public function costCenter($DadosId = null) {

        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $this->DadosId = (int) $DadosId;

        if (!empty($this->DadosId)) {
            $this->editCostCenterPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Centro de custo não foi encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'cost-centers/list';
            header("Location: $UrlDestino");
        }
    }

    private function editCostCenterPriv() {
        if (!empty($this->Dados['EditCostCenter'])) {
            unset($this->Dados['EditCostCenter']);
            $editCostCenter = new \App\adms\Models\AdmsEditCostCenter();
            $editCostCenter->altCostCenter($this->Dados);
            if ($editCostCenter->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Centro de custo</strong>  atualizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $UrlDestino = URLADM . 'view-cost-center/cost-center/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editCostCenterViewPriv();
            }
        } else {
            $viewCostCenter = new \App\adms\Models\AdmsEditCostCenter();
            $this->Dados['form'] = $viewCostCenter->costCenter($this->DadosId);
            $this->editCostCenterViewPriv();
        }
    }

    private function editCostCenterViewPriv() {
        if ($this->Dados['form']) {

            $listarSelect = new \App\adms\Models\AdmsEditCostCenter();
            $this->Dados['select'] = $listarSelect->listAdd();

            $botao = ['list_cost' => ['menu_controller' => 'cost-centers', 'menu_metodo' => 'list'], 'view_cost' => ['menu_controller' => 'view-cost-center', 'menu_metodo' => 'cost-center']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/costCenter/editCostCenter", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Centro de custo não foi encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'cost-centers/list';
            header("Location: $UrlDestino");
        }
    }
}
