<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AccountingAccount
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AccountingAccount {

    private $Dados;
    private $PageId;

    public function list($PageId = null) {
        
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['add_account' => ['menu_controller' => 'add-accounting-account', 'menu_metodo' => 'accounting-account'],
            'view_account' => ['menu_controller' => 'view-accounting-account', 'menu_metodo' => 'accounting-account'],
            'edit_account' => ['menu_controller' => 'edit-accounting-account', 'menu_metodo' => 'accounting-account'],
            'del_account' => ['menu_controller' => 'delete-accounting-account', 'menu_metodo' => 'accounting-account']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listAccount = new \App\adms\Models\AdmsListAccountingAccount();
        $this->Dados['listAccount'] = $listAccount->list($this->PageId);
        $this->Dados['paginacao'] = $listAccount->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/accountingAccount/listAccountingAccount", $this->Dados);
        $carregarView->renderizar();
    }

}
