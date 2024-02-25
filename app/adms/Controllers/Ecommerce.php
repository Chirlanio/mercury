<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Ecommerce
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class Ecommerce {

    private $Dados;
    private $PageId;

    public function list($PageId = null) {

        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['add_ecommerce_order' => ['menu_controller' => 'add-ecommerce-order', 'menu_metodo' => 'add-order'],
            'create_ecommerce_order' => ['menu_controller' => 'create-spreadsheet-ecommerce-order', 'menu_metodo' => 'create'],
            'view_ecommerce_order' => ['menu_controller' => 'view-ecommerce-order', 'menu_metodo' => 'view-order'],
            'edit_ecommerce_order' => ['menu_controller' => 'edit-ecommerce-order', 'menu_metodo' => 'edit-order'],
            'del_ecommerce_order' => ['menu_controller' => 'delete-ecommerce-order', 'menu_metodo' => 'delete-order']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        
        $listSelect = new \App\adms\Models\AdmsListEcommerceOrder();
        $this->Dados['select'] = $listSelect->listAdd();

        $listEcomemrce = new \App\adms\Models\AdmsListEcommerceOrder();
        $this->Dados['list_order'] = $listEcomemrce->list($this->PageId);
        $this->Dados['paginacao'] = $listEcomemrce->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/ecommerce/listEcommerceOrder", $this->Dados);
        $carregarView->renderizar();
    }

}
