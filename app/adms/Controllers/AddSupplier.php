<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AddSupplier
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AddSupplier {

    private $Data;

    public function addSupplier() {
        
        $this->Data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($this->Data['AddSupplier'])) {
            unset($this->Data['AddSupplier']);
            $AddSupplier = new \App\adms\Models\AdmsAddSupplier();
            $AddSupplier->addSupplier($this->Data);
            if ($AddSupplier->getResultado()) {
                $UrlDestino = URLADM . 'supplier/list';
                header("Location: $UrlDestino");
            } else {
                $this->Data['form'] = $this->Data;
                $this->addSupplierViewPriv();
            }
        } else {
            $this->addSupplierViewPriv();
        }
    }

    private function addSupplierViewPriv() {
        
        $botao = ['list_supplier' => ['menu_controller' => 'supplier', 'menu_metodo' => 'list']];
        
        $listButton = new \App\adms\Models\AdmsBotao();
        $this->Data['botao'] = $listButton->valBotao($botao);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->Data['menu'] = $listMenu->itemMenu();
        
        $listSelect = new \App\adms\Models\AdmsAddSupplier();
        $this->Data['select']=$listSelect->listAdd();
        
        $carregarView = new \Core\ConfigView("adms/Views/supplier/addSupplier", $this->Data);
        $carregarView->renderizar();
    }

}
