<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AddOrderPayments
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meia Sola
 */
class AddOrderPayments {

    private $Dados;

    public function orderPayment() {

        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->Dados['AddOrder'])) {
            unset($this->Dados['AddOrder']);
            
            $this->Dados['file_name'] = ($_FILES['file_name'] ? $_FILES['file_name'] : null);
            $addOrder = new \App\adms\Models\AdmsAddOrderPayment();
            $addOrder->addOrder($this->Dados);
            
            if ($addOrder->getResultado()) {
                $UrlDestino = URLADM . 'order-payments/list';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->addOrderPaymentViewPriv();
            }
        } else {
            $this->addOrderPaymentViewPriv();
        }
    }

    private function addOrderPaymentViewPriv() {

        $listarSelect = new \App\adms\Models\AdmsAddOrderPayment();
        $this->Dados['select'] = $listarSelect->listAdd();

        $botao = ['list_order' => ['menu_controller' => 'order-payments', 'menu_metodo' => 'list'],
            'add_order' => ['menu_controller' => 'add-order-payments', 'menu_metodo' => 'order-payment'],
            'veiew_order' => ['menu_controller' => 'view-order-payments', 'menu_metodo' => 'order-payment'],
            'edit_order' => ['menu_controller' => 'edit-order-payments', 'menu_metodo' => 'order-payment'],
            'del_order' => ['menu_controller' => 'delete-order-payments', 'menu_metodo' => 'order-payment']];

        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        if (!empty($this->Dados['AddOrder'])) {
        }

        $carregarView = new \Core\ConfigView("adms/Views/orderPayment/addOrderPayments", $this->Dados);
        $carregarView->renderizar();
    }
}
