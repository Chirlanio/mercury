<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Brands
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class Brands {

    private $Dados;
    private $PageId;

    public function list($PageId = null) {
        
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['add_brand' => ['menu_controller' => 'add-brands', 'menu_metodo' => 'add-brand'],
            'view_brand' => ['menu_controller' => 'view-brands', 'menu_metodo' => 'view-brand'],
            'edit_brand' => ['menu_controller' => 'edit-brands', 'menu_metodo' => 'edit-brand'],
            'del_brand' => ['menu_controller' => 'delete-brands', 'menu_metodo' => 'delete-brand']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listBrand = new \App\adms\Models\AdmsListBrands();
        $this->Dados['listBrand'] = $listBrand->listBrand($this->PageId);
        $this->Dados['paginacao'] = $listBrand->getResultado();

        $carregarView = new \Core\ConfigView("adms/Views/brand/listBrand", $this->Dados);
        $carregarView->renderizar();
    }

}
