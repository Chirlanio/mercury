<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditTypePayments
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditTypePayments {

    private $Dados;
    private $DadosId;

    public function typePayment($DadosId = null) {
        
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        $this->DadosId = (int) $DadosId;
        
        if (!empty($this->DadosId)) {
            $this->editTypePaymentsPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Tipo de pagameto não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'type-payments/list';
            header("Location: $UrlDestino");
        }
    }

    private function editTypePaymentsPriv() {
        if (!empty($this->Dados['EditType'])) {
            unset($this->Dados['EditType']);
            $editType = new \App\adms\Models\AdmsEditTypePayment();
            $editType->altType($this->Dados);
            if ($editType->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Tipo de pagamento</strong> atualizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $UrlDestino = URLADM . 'view-type-payments/type-payment/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editTtpePaymentViewPriv();
            }
        } else {
            $viewType = new \App\adms\Models\AdmsEditTypePayment();
            $this->Dados['form'] = $viewType->viewType($this->DadosId);
            $this->editTtpePaymentViewPriv();
        }
    }

    private function editTtpePaymentViewPriv() {
        if ($this->Dados['form']) {
            
            $botao = ['list_pay' => ['menu_controller' => 'type-payments', 'menu_metodo' => 'list'],'view_pay' => ['menu_controller' => 'view-type-payments', 'menu_metodo' => 'type-payment']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            
            $listSelect = new \App\adms\Models\AdmsEditTypePayment();
            $this->Dados['select'] = $listSelect->listAdd();

            $carregarView = new \Core\ConfigView("adms/Views/typePayment/editTypePayment", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Tipo de pagameto não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'view-type-payments/type-payment/';
            header("Location: $UrlDestino");
        }
    }

}
