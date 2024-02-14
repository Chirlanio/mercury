<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of PersonnelMoviments
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class PersonnelMoviments {

    private $Dados;
    private $PageId;

    public function list($PageId = null) {

        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['add_moviment' => ['menu_controller' => 'add-personnel-moviments', 'menu_metodo' => 'add-moviment'],
            'view_moviment' => ['menu_controller' => 'view-personnel-movements', 'menu_metodo' => 'view-moviment'],
            'edit_moviment' => ['menu_controller' => 'edit-personnel-movements', 'menu_metodo' => 'edit-moviment'],
            'del_moviment' => ['menu_controller' => 'delete-personnel-movements', 'menu_metodo' => 'delete-moviment']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        
        $listSelect = new \App\adms\Models\AdmsListPersonnelMovements();
        $this->Dados['select'] = $listSelect->listAdd();

        $listPersonnel = new \App\adms\Models\AdmsListPersonnelMovements();
        $this->Dados['list_moviment'] = $listPersonnel->list($this->PageId);
        $this->Dados['paginacao'] = $listPersonnel->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/personnelMoviment/listPersonnelMoviments", $this->Dados);
        $carregarView->renderizar();
    }

}
