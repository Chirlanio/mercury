<?php

namespace App\cpadms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of SearchSupplier
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class SearchSupplier {

    private $Dados;
    private $DadosForm;
    private $PageId;

    public function list($PageId = null) {

        $botao = ['list_supplier' => ['menu_controller' => 'supplier', 'menu_metodo' => 'list'],
            'add_supplier' => ['menu_controller' => 'add-supplier', 'menu_metodo' => 'add-supplier'],
            'view_supplier' => ['menu_controller' => 'view-supplier', 'menu_metodo' => 'view-supplier'],
            'edit_supplier' => ['menu_controller' => 'edit-supplier', 'menu_metodo' => 'edit-supplier'],
            'del_supplier' => ['menu_controller' => 'delete-supplier', 'menu_metodo' => 'delete-supplier']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $this->DadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($this->DadosForm['SearchSupplier'])) {
            unset($this->DadosForm['SearchSupplier']);
        } else {
            $this->PageId = (int) $PageId ? $PageId : 1;
            $this->DadosForm['searchSupplier'] = filter_input(INPUT_GET, 'search', FILTER_DEFAULT);
        }

        $list = new \App\cpadms\Models\CpAdmsSearchSupplier();
        $this->Dados['list_supplier'] = $list->list($this->PageId, $this->DadosForm);
        $this->Dados['paginacao'] = $list->getResultado();

        $carregarView = new \Core\ConfigView("cpadms/Views/supplier/searchSupplier", $this->Dados);
        $carregarView->renderizar();
    }

}
