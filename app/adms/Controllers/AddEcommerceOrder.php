<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AddEcommerceOrder
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meia Sola
 */
class AddEcommerceOrder {

    private $Dados;

    public function addOrder() {

        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->Dados['AddOrder'])) {
            unset($this->Dados['AddOrder']);
            
            $addOrder = new \App\adms\Models\AdmsAddEcommerceOrder();
            $addOrder->addOrder($this->Dados);
            
            if ($addOrder->getResultado()) {
                $UrlDestino = URLADM . 'ecommerce/list';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->addEcommerceViewPriv();
            }
        } else {
            $this->addEcommerceViewPriv();
        }
    }

    private function addEcommerceViewPriv() {

        $listSelect = new \App\adms\Models\AdmsAddEcommerceOrder();
        $this->Dados['select'] = $listSelect->listAdd();

        $botao = ['list_ecommerce_order' => ['menu_controller' => 'ecommerce', 'menu_metodo' => 'list'],
            'add_ecommerce_order' => ['menu_controller' => 'add-ecommerce-order', 'menu_metodo' => 'add-order'],
            'view_ecommerce_order' => ['menu_controller' => 'view-ecommerce-order', 'menu_metodo' => 'view-order'],
            'edit_ecommerce_order' => ['menu_controller' => 'edit-ecommerce-order', 'menu_metodo' => 'edit-order'],
            'del_ecommerce_order' => ['menu_controller' => 'delete-ecommerce-order', 'menu_metodo' => 'delete-order']];

        $listBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listBotao->valBotao($botao);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listMenu->itemMenu();

        $carregarView = new \Core\ConfigView("adms/Views/ecommerce/addEcommerceOrder", $this->Dados);
        $carregarView->renderizar();
    }
}
