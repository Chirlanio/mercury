<?php

namespace App\cpadms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CreateSpreadsheetOrderPayments
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CreateSpreadsheetOrderPayments {

    private $Dados;
    private $PageId;

    public function create($PageId = null) {

        $this->PageId = (int) $PageId;
        
        $this->Dados['search'] = filter_input(INPUT_GET, 'search', FILTER_DEFAULT);
        $this->Dados['searchDateInitial'] = filter_input(INPUT_GET, 'searchDateInitial', FILTER_DEFAULT);
        $this->Dados['searchDateFinal'] = filter_input(INPUT_GET, 'searchDateFinal', FILTER_DEFAULT);
        
        $botao = ['create' => ['menu_controller' => 'create-spreadsheet-order-payments', 'menu_metodo' => 'create'],
            'listOrder' => ['menu_controller' => 'create-spreadsheet-order-payments', 'menu_metodo' => 'create']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listOrder = new \App\cpadms\Models\CpAdmsCreateSpreadsheetOrderpayments();
        $this->Dados['listOrder'] = $listOrder->list($this->PageId, $this->Dados);

        $carregarView = new \App\cpadms\core\ConfigView("cpadms/Views/orderPayments/createSpreadsheetOrderPayment", $this->Dados);
        $carregarView->renderizarListar();
    }

}
