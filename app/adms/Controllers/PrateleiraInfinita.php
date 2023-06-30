<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of PrateleiraInfinita
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class PrateleiraInfinita {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {
        
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['list_ped' => ['menu_controller' => 'cadastrar-ped', 'menu_metodo' => 'cad-ped'],
            'vis_ped' => ['menu_controller' => 'ver-ped', 'menu_metodo' => 'ver-dashboard'],
            'edit_ped' => ['menu_controller' => 'editar-ped', 'menu_metodo' => 'edit-ped'],
            'del_ped' => ['menu_controller' => 'apagar-ped', 'menu_metodo' => 'apagar-ped']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        
        $listarSelect = new \App\adms\Models\AdmsListarPed();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $listarPed = new \App\adms\Models\AdmsListarPed();
        $this->Dados['listPed'] = $listarPed->listarPed($this->PageId);
        $this->Dados['paginacao'] = $listarPed->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/prateleira/listarPrateleira", $this->Dados);
        $carregarView->renderizar();
    }

}
