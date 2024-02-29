<?php

namespace App\cpadms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of SearchEcommerceOrder
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class SearchEcommerceOrder {

    private $Dados;
    private $DadosForm;
    private $PageId;

    public function list($PageId = null) {

        $botao = ['list_ecommerce_order' => ['menu_controller' => 'ecommerce', 'menu_metodo' => 'list'],
            'add_ecommerce_order' => ['menu_controller' => 'add-ecommerce-order', 'menu_metodo' => 'add-order'],
            'view_ecommerce_order' => ['menu_controller' => 'view-ecommerce-order', 'menu_metodo' => 'view-order'],
            'edit_ecommerce_order' => ['menu_controller' => 'edit-ecommerce-order', 'menu_metodo' => 'edit-order'], 'del_ecommerce_order' => ['menu_controller' => 'delete-ecommerce-order', 'menu_metodo' => 'del-order']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $this->DadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($this->DadosForm['SearchEcommerce'])) {
            unset($this->DadosForm['SearchEcommerce']);
        } else {
            $this->PageId = (int) $PageId ? $PageId : 1;
            $this->DadosForm['search'] = filter_input(INPUT_GET, 'search', FILTER_DEFAULT);
        }

        $list = new \App\cpadms\Models\CpAdmsSearchEcommerceOrder();
        $this->Dados['list_ecommerce'] = $list->list($this->PageId, $this->DadosForm);
        $this->Dados['paginacao'] = $list->getResultado();

        $carregarView = new \Core\ConfigView("cpadms/Views/ecommerce/searchEcommerceOrder", $this->Dados);
        $carregarView->renderizar();
    }

}
