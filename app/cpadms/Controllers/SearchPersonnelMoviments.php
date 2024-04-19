<?php

namespace App\cpadms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of SearchPersonnelMoviments
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class SearchPersonnelMoviments {

    private $Dados;
    private $DadosForm;
    private $PageId;

    public function list($PageId = null) {

        $botao = ['list_moviment' => ['menu_controller' => 'personnel-moviments', 'menu_metodo' => 'list'], 'create_sheet' => ['menu_controller' => 'create-spreadsheet-order-payments', 'menu_metodo' => 'create'], 'add_moviment' => ['menu_controller' => 'add-personnel-moviments', 'menu_metodo' => 'add-moviment'], 'view_moviment' => ['menu_controller' => 'view-personnel-moviments', 'menu_metodo' => 'view-moviment'], 'edit_moviment' => ['menu_controller' => 'edit-personnel-moviments', 'menu_metodo' => 'edit-moviment'], 'del_moviment' => ['menu_controller' => 'delete-personnel-moviments', 'menu_metodo' => 'delete-moviment']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $this->DadosForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($this->DadosForm['SearchMoviments'])) {
            unset($this->DadosForm['SearchMoviments']);
        } else {
            $this->PageId = (int) $PageId ? $PageId : 1;
            $this->DadosForm['search'] = filter_input(INPUT_GET, 'search', FILTER_DEFAULT);
        }

        $listMoviment = new \App\cpadms\Models\CpAdmsSearchPersonnelMoviments();
        $this->Dados['list_moviment'] = $listMoviment->list($this->PageId, $this->DadosForm);
        $this->Dados['paginacao'] = $listMoviment->getResultado();

        $carregarView = new \Core\ConfigView("cpadms/Views/personnelMoviments/searchPersonnelMoviments", $this->Dados);
        $carregarView->renderizar();
    }

}
