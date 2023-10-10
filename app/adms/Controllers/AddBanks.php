<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AddBanks
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AddBanks {

    private $Data;

    public function addBank() {
        
        $this->Data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($this->Data['AddBank'])) {
            unset($this->Data['AddBank']);
            $AddBank = new \App\adms\Models\AdmsAddBank();
            $AddBank->addBank($this->Data);
            if ($AddBank->getResultado()) {
                $UrlDestino = URLADM . 'banks/list';
                header("Location: $UrlDestino");
            } else {
                $this->Data['form'] = $this->Data;
                $this->addBankViewPriv();
            }
        } else {
            $this->addBankViewPriv();
        }
    }

    private function addBankViewPriv() {
        
        $botao = ['list_bank' => ['menu_controller' => 'banks', 'menu_metodo' => 'list']];
        
        $listButton = new \App\adms\Models\AdmsBotao();
        $this->Data['botao'] = $listButton->valBotao($botao);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->Data['menu'] = $listMenu->itemMenu();
        
        $listSelect = new \App\adms\Models\AdmsAddBank();
        $this->Data['select']=$listSelect->listAdd();
        
        $carregarView = new \Core\ConfigView("adms/Views/bank/addBank", $this->Data);
        $carregarView->renderizar();
    }

}
