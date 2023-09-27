<?php

namespace App\cpadms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of PesqEstorno
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class SearchOrderPayments {

    private $Dados;
    private $DadosForm;
    private $PageId;

    public function list($PageId = null) {

        $botao = ['list_payment' => ['menu_controller' => 'order-payments', 'menu_metodo' => 'list'],
            'add_payment' => ['menu_controller' => 'add-order-payments', 'menu_metodo' => 'order-payment'],
            'view_payment' => ['menu_controller' => 'view-order-payments', 'menu_metodo' => 'order-payment'],
            'edit_payment' => ['menu_controller' => 'edit-order-payments', 'menu_metodo' => 'order-payment'],
            'del_payment' => ['menu_controller' => 'delete-order-payments', 'menu_metodo' => 'order-payment']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $this->DadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->DadosForm['SearchOrder'])) {
            unset($this->DadosForm['SearchOrder']);
        } else {
            $this->PageId = (int) $PageId ? $PageId : 1;
            $this->DadosForm['search'] = filter_input(INPUT_GET, 'search', FILTER_DEFAULT);
        }

        $listOrder = new \App\cpadms\Models\CpAdmsSearchOrderPayments();
        $this->Dados['listOrder'] = $listOrder->list($this->PageId, $this->DadosForm);
        $this->Dados['paginacao'] = $listOrder->getResultadoAj();

        $carregarView = new \Core\ConfigView("cpadms/Views/orderPayments/searchOrderPayment", $this->Dados);
        $carregarView->renderizar();
    }

}
