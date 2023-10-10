<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Banks
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class Banks {

    private $Dados;
    private $PageId;

    public function list($PageId = null) {
        
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['add_bank' => ['menu_controller' => 'add-banks', 'menu_metodo' => 'add-bank'],
            'view_bank' => ['menu_controller' => 'view-banks', 'menu_metodo' => 'view-bank'],
            'edit_bank' => ['menu_controller' => 'edit-banks', 'menu_metodo' => 'edit-bank'],
            'del_bank' => ['menu_controller' => 'delete-banks', 'menu_metodo' => 'delete-bank']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listBands = new \App\adms\Models\AdmsListBanks();
        $this->Dados['listBank'] = $listBands->listBanks($this->PageId);
        $this->Dados['paginacao'] = $listBands->getResultado();

        $carregarView = new \Core\ConfigView("adms/Views/bank/listBank", $this->Dados);
        $carregarView->renderizar();
    }

}
