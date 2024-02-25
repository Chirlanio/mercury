<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditEcommerceOrder
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meia Sola
 */
class EditEcommerceOrder {

    private $Dados;
    private $DadosId;

    public function editOrder($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editEcommerceOrderPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Solicitação não encontrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'ecommerce/list';
            header("Location: $UrlDestino");
        }
    }

    private function editEcommerceOrderPriv() {
        if (!empty($this->Dados['EditOrder'])) {
            unset($this->Dados['EditOrder']);

            $editOrder = new \App\adms\Models\AdmsEditEcommerceOrder();
            $editOrder->altOrder($this->Dados);

            if ($editOrder->getResultado()) {
                $UrlDestino = URLADM . 'ecommerce/list';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editEcommerceOrderViewPriv();
            }
        } else {
            $viewOrder = new \App\adms\Models\AdmsEditEcommerceOrder();
            $this->Dados['form'] = $viewOrder->viewOrder($this->DadosId);
            $this->editEcommerceOrderViewPriv();
        }
    }

    private function editEcommerceOrderViewPriv() {
        if ($this->Dados['form']) {

            $listarSelect = new \App\adms\Models\AdmsEditEcommerceOrder();
            $this->Dados['select'] = $listarSelect->listAdd();

            $botao = ['view_ecommerce_order' => ['menu_controller' => 'view-ecommerce-order', 'menu_metodo' => 'view-order'],
                'list_ecommerce_order' => ['menu_controller' => 'ecommerce', 'menu_metodo' => 'list']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/ecommerce/editEcommerceOrder", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Só é permitida a atualização nas Situações \"Pendente\"!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'ecommerce/list';
            header("Location: $UrlDestino");
        }
    }
}
