<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ViewCostCenter
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ViewCostCenter {

    private $Dados;
    private $DadosId;

    public function costCenter($DadosId = null) {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $viewCostCenter = new \App\adms\Models\AdmsViewCostCenter();
            $this->Dados['dados_cost'] = $viewCostCenter->costCenter($this->DadosId);

            $botao = ['list_cost' => ['menu_controller' => 'cost-centers', 'menu_metodo' => 'list'],
                'edit_cost' => ['menu_controller' => 'edit-cost-center', 'menu_metodo' => 'cost-center'],
                'del_cost' => ['menu_controller' => 'del-cost-center', 'menu_metodo' => 'cost-center']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/costCenter/viewCostCenter", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Centro de custo não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'cost-centers/list';
            header("Location: $UrlDestino");
        }
    }

}
