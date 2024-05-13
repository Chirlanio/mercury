<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Relocation
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class Relocation {

    private $Dados;
    private $PageId;

    public function list($PageId = null) {
        
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['add_relocation' => ['menu_controller' => 'add-relocation', 'menu_metodo' => 'add-relocation'],
            'view_relocation' => ['menu_controller' => 'view-relocation', 'menu_metodo' => 'view-relocation'],
            'edit_relocation' => ['menu_controller' => 'edit-relocation', 'menu_metodo' => 'edit-relocation'],
            'del_relocation' => ['menu_controller' => 'delete-relocation', 'menu_metodo' => 'delete-relocation']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarSelect = new \App\adms\Models\AdmsListRelocation();
        $this->Dados['select'] = $listarSelect->listAdd();

        $listRelocation = new \App\adms\Models\AdmsListRelocation();
        $this->Dados['list_relocation'] = $listRelocation->listRelocation($this->PageId);
        $this->Dados['paginacao'] = $listRelocation->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/relocation/listRelocation", $this->Dados);
        $carregarView->renderizar();
    }

}
