<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ViewRelocation
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ViewRelocation {

    private $Dados;
    private $PageId;
    public function viewRelocation($PageId = null) {
        
        $this->PageId = (int) $PageId ? $PageId : 1;
        $this->Dados['pg'] = $this->PageId;
        $this->Dados['id'] = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
        $this->Dados['origem'] = filter_input(INPUT_GET, "origem", FILTER_DEFAULT);
        $this->Dados['destino'] = filter_input(INPUT_GET, "destino", FILTER_DEFAULT);
        //var_dump($this->Dados);

        $botao = ['list_relocation' => ['menu_controller' => 'relocation', 'menu_metodo' => 'list'],
            'edit_relocation' => ['menu_controller' => 'edit-relocation', 'menu_metodo' => 'edit-relocation'],
            'del_relocation' => ['menu_controller' => 'delete-relocation', 'menu_metodo' => 'del-relocation']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $viewRelocation = new \App\adms\Models\AdmsViewRelocation();
        $this->Dados['listRelocation'] = $viewRelocation->listRelocation($this->PageId, $this->Dados);
        $this->Dados['paginacao'] = $viewRelocation->getResultadoPg();

        $this->Dados['dados_relocation'] = $viewRelocation->viewRelocation($this->Dados['id']);
        
        $this->Dados['listQuantity'] = $viewRelocation->viewQuantity($this->Dados['id']);

        $carregarView = new \Core\ConfigView("adms/Views/relocation/viewRelocation", $this->Dados);
        $carregarView->renderizar();
    }

}
