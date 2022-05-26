<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of SituacaoBalanco
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class SituacaoBalanco {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {
        
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_sit' => ['menu_controller' => 'cadastrar-sit-balanco', 'menu_metodo' => 'cad-sit'],
            'edit_sit' => ['menu_controller' => 'editar-sit-balanco', 'menu_metodo' => 'edit-sit'],
            'del_sit' => ['menu_controller' => 'apagar-sit-balanco', 'menu_metodo' => 'apagar-sit']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarSit = new \App\adms\Models\AdmsListarSitBalanco();
        $this->Dados['listSit'] = $listarSit->listarSitBalanco($this->PageId);
        $this->Dados['paginacao'] = $listarSit->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/situacaoBalanco/listarSitBalanco", $this->Dados);
        $carregarView->renderizar();
    }

}
