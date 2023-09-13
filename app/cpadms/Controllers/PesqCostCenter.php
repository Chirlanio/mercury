<?php

namespace App\cpadms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of PesqCostCenter
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class PesqCostCenter {

    private $Dados;
    private $DadosForm;
    private $PageId;

    public function list($PageId = null) {

        $botao = ['list_cost' => ['menu_controller' => 'cost-centers', 'menu_metodo' => 'list'],
            'add_cost' => ['menu_controller' => 'add-cost-center', 'menu_metodo' => 'cost-center'],
            'view_cost' => ['menu_controller' => 'view-cost-center', 'menu_metodo' => 'cost-center'],
            'edit_cost' => ['menu_controller' => 'edit-cost-center', 'menu_metodo' => 'cost-center'],
            'del_cost' => ['menu_controller' => 'delete-cost-center', 'menu_metodo' => 'cost-center']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $this->DadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->DadosForm['PesqCostCenter'])) {
            unset($this->DadosForm['PesqCostCenter']);
        } else {
            $this->PageId = (int) $PageId ? $PageId : 1;
            $this->DadosForm['search'] = filter_input(INPUT_GET, 'pesquisar', FILTER_DEFAULT);
        }

        $listarPagina = new \App\cpadms\Models\CpAdmsPesqCostCenter();
        $this->Dados['listCostCenter'] = $listarPagina->list($this->PageId, $this->DadosForm);
        $this->Dados['paginacao'] = $listarPagina->getResult();

        $carregarView = new \Core\ConfigView("cpadms/Views/costCenter/pesqCostCenter", $this->Dados);
        $carregarView->renderizar();
    }

}
