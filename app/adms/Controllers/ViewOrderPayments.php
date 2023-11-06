<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ViewOrderPayment
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ViewOrderPayments {

    private $Dados;
    private $DadosId;

    public function orderPayment($DadosId = null) {

        $this->DadosId = (int) $DadosId;

        if (!empty($this->DadosId)) {

            $viewOrder = new \App\adms\Models\AdmsViewOrderPayment();
            $this->Dados['dados_order'] = $viewOrder->viewOrder($this->DadosId);

            $installments = new \App\adms\Models\AdmsViewOrderPayment();
            $this->Dados['installments'] = $installments->listInstallments($this->DadosId);

            $botao = ['list_order' => ['menu_controller' => 'order-payments', 'menu_metodo' => 'list'],
                'edit_order' => ['menu_controller' => 'edit-order-payments', 'menu_metodo' => 'order-payment'],
                'del_order' => ['menu_controller' => 'delete-order-payments', 'menu_metodo' => 'order-payment']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/orderPayment/viewOrderPayment", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Solicitação não encontrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'order-payment/list';
            header("Location: $UrlDestino");
        }
    }
}
