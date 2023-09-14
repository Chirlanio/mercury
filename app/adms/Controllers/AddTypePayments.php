<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AddTypePayments
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AddTypePayments {

    private $Dados;

    public function typePayment() {
        
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($this->Dados['AddType'])) {
            unset($this->Dados['AddType']);
            $addType = new \App\adms\Models\AdmsAddTypePayment();
            $addType->addType($this->Dados);
            if ($addType->getResultado()) {
                $UrlDestino = URLADM . 'type-payments/list';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->addTypePaymentViewPriv();
            }
        } else {
            $this->addTypePaymentViewPriv();
        }
    }

    private function addTypePaymentViewPriv() {
        
        $botao = ['list_pay' => ['menu_controller' => 'type-payments', 'menu_metodo' => 'list']];
        
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        
        $listarSelect = new \App\adms\Models\AdmsAddTypePayment();
        $this->Dados['select']=$listarSelect->listAdd();
        
        $carregarView = new \Core\ConfigView("adms/Views/typePayment/addTypePayment", $this->Dados);
        $carregarView->renderizar();
    }

}
