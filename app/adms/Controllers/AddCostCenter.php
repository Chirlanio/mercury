<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AddCostCenter
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AddCostCenter {

    private $Dados;

    public function costCenter() {

        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->Dados['AddCostCenter'])) {
            unset($this->Dados['AddCostCenter']);
            $AddCostCenter = new \App\adms\Models\AdmsAddCostCenter();
            $AddCostCenter->addCostCenter($this->Dados);
            if ($AddCostCenter->getResultado()) {
                $UrlDestino = URLADM . 'cost-centers/list';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->addCostCenterViewPriv();
            }
        } else {
            $this->addCostCenterViewPriv();
        }
    }

    private function addCostCenterViewPriv() {

        $botao = ['list_cost' => ['menu_controller' => 'cost-centers', 'menu_metodo' => 'list']];

        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarSelect = new \App\adms\Models\AdmsAddCostCenter();
        $this->Dados['select'] = $listarSelect->listAdd();

        $carregarView = new \Core\ConfigView("adms/Views/costCenter/addCostCenter", $this->Dados);
        $carregarView->renderizar();
    }
}
