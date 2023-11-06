<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditOrderPayments
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meia Sola
 */
class EditOrderPayments {

    private $Dados;
    private $DadosId;
    
    public function orderPayment($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editOrderPaymentPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Solicitação não encontrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'order-payments/list';
            header("Location: $UrlDestino");
        }
    }

    private function editOrderPaymentPriv() {
        if (!empty($this->Dados['EditOrder'])) {
            unset($this->Dados['EditOrder']);
            $this->Dados['new_files'] = ($_FILES['new_files'] ? $_FILES['new_files'] : $this->Dados['file_name']);

            $editOrder = new \App\adms\Models\AdmsEditOrderPayment();
            $editOrder->altOrder($this->Dados);

            if ($editOrder->getResultado()) {
                $UrlDestino = URLADM . 'order-payments/list';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editOrderPaymentViewPriv();
            }
        } else {
            $viewOrder = new \App\adms\Models\AdmsEditOrderPayment();
            $this->Dados['form'] = $viewOrder->viewOrder($this->DadosId);
            $this->editOrderPaymentViewPriv();
        }
    }

    private function editOrderPaymentViewPriv() {
        if ($this->Dados['form']) {

            $listarSelect = new \App\adms\Models\AdmsEditOrderPayment();
            $this->Dados['select'] = $listarSelect->listAdd();

            $botao = ['view_order' => ['menu_controller' => 'view-order-payments', 'menu_metodo' => 'order-payment'],
                'list_order' => ['menu_controller' => 'order-payments', 'menu_metodo' => 'list']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/orderPayment/editOrderPayment", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Solicitação não encontrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'order-payments/list';
            header("Location: $UrlDestino");
        }
    }

}
