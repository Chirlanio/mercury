<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Dashboard
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class Dashboard {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {
        
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['listDash' => ['menu_controller' => 'cadastrar-dashboard', 'menu_metodo' => 'cad-dash'],
            'vis_dash' => ['menu_controller' => 'ver-dashboard', 'menu_metodo' => 'ver-dashboard'],
            'edit_dash' => ['menu_controller' => 'editar-dashboard', 'menu_metodo' => 'edit-dashboard'],
            'del_dash' => ['menu_controller' => 'apagar-dashboard', 'menu_metodo' => 'apagar-dashboard']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarDashboard = new \App\adms\Models\AdmsListarDashboard();
        $this->Dados['listDash'] = $listarDashboard->listarDashboard($this->PageId);
        $this->Dados['paginacao'] = $listarDashboard->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/dashboard/listar", $this->Dados);
        $carregarView->renderizar();
    }

}
