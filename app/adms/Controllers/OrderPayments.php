<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of OrderPayments
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class OrderPayments {

    private $Dados;
    private $PageId;

    public function list($PageId = null) {

        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['add_payment' => ['menu_controller' => 'add-order-payments', 'menu_metodo' => 'order-payment'],
            'view_payment' => ['menu_controller' => 'view-order-payments', 'menu_metodo' => 'order-payment'],
            'edit_payment' => ['menu_controller' => 'edit-order-payments', 'menu_metodo' => 'order-payment'],
            'del_payment' => ['menu_controller' => 'delete-order-payments', 'menu_metodo' => 'order-payment']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        
        $listSelect = new \App\adms\Models\AdmsListOrderPayments();
        $this->Dados['select'] = $listSelect->listAdd();

        $listBacklog = new \App\adms\Models\AdmsListOrderPayments();
        $this->Dados['list_backlog'] = $listBacklog->listBacklog($this->PageId);
        $this->Dados['paginacao'] = $listBacklog->getResultadoPg();

        $listDoing = new \App\adms\Models\AdmsListOrderPayments();
        $this->Dados['list_doing'] = $listDoing->listDoing($this->PageId);
        $this->Dados['paginacao'] = $listDoing->getResultadoPg();

        $listWaiting = new \App\adms\Models\AdmsListOrderPayments();
        $this->Dados['list_waiting'] = $listWaiting->listWaiting($this->PageId);
        $this->Dados['paginacao'] = $listWaiting->getResultadoPg();

        $listDone = new \App\adms\Models\AdmsListOrderPayments();
        $this->Dados['list_done'] = $listDone->listDone($this->PageId);
        $this->Dados['paginacao'] = $listDone->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/orderPayment/listOrderPayment", $this->Dados);
        $carregarView->renderizar();
    }

}
