<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AddBrands
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AddBrands {

    private $Data;

    public function addBrand() {
        
        $this->Data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($this->Data['AddBrand'])) {
            unset($this->Data['AddBrand']);
            $AddBrand = new \App\adms\Models\AdmsAddBrands();
            $AddBrand->addBrand($this->Data);
            if ($AddBrand->getResultado()) {
                $UrlDestino = URLADM . 'brands/list';
                header("Location: $UrlDestino");
            } else {
                $this->Data['form'] = $this->Data;
                $this->addBrandViewPriv();
            }
        } else {
            $this->addBrandViewPriv();
        }
    }

    private function addBrandViewPriv() {
        
        $botao = ['list_brand' => ['menu_controller' => 'brands', 'menu_metodo' => 'list']];
        
        $listButton = new \App\adms\Models\AdmsBotao();
        $this->Data['botao'] = $listButton->valBotao($botao);

        $listMenu = new \App\adms\Models\AdmsMenu();
        $this->Data['menu'] = $listMenu->itemMenu();
        
        $listSelect = new \App\adms\Models\AdmsAddBrands();
        $this->Data['select']=$listSelect->listAdd();
        
        $carregarView = new \Core\ConfigView("adms/Views/brand/addBrand", $this->Data);
        $carregarView->renderizar();
    }

}
