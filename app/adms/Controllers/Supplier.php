<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Supplier
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class Supplier {

    private $Dados;
    private $PageId;

    public function list($PageId = null) {
        
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['add_supplier' => ['menu_controller' => 'add-supplier', 'menu_metodo' => 'add-supplier'],
            'view_supplier' => ['menu_controller' => 'view-supplier', 'menu_metodo' => 'view-supplier'],
            'edit_supplier' => ['menu_controller' => 'edit-supplier', 'menu_metodo' => 'edit-supplier'],
            'del_supplier' => ['menu_controller' => 'delete-supplier', 'menu_metodo' => 'delete-supplier']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarSupplier = new \App\adms\Models\AdmsListarSupplier();
        $this->Dados['listSupplier'] = $listarSupplier->listSupplier($this->PageId);
        $this->Dados['paginacao'] = $listarSupplier->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/supplier/listSupplier", $this->Dados);
        $carregarView->renderizar();
    }

}
