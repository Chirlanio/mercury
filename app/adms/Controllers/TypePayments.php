<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of TypePayments
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class TypePayments {

    private $Dados;
    private $PageId;

    public function list($PageId = null) {
        
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['add_pay' => ['menu_controller' => 'add-type-payments', 'menu_metodo' => 'type-payment'],
            'view_pay' => ['menu_controller' => 'view-type-payments', 'menu_metodo' => 'type-payment'],
            'edit_pay' => ['menu_controller' => 'edit-type-payments', 'menu_metodo' => 'type-payment'],
            'del_pay' => ['menu_controller' => 'delete-type-payments', 'menu_metodo' => 'type-payment']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listType = new \App\adms\Models\AdmsListTypePayment();
        $this->Dados['listType'] = $listType->listTypes($this->PageId);
        $this->Dados['paginacao'] = $listType->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/typePayment/listTypePayment", $this->Dados);
        $carregarView->renderizar();
    }

}
