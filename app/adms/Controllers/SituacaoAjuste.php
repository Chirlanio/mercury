<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Situacao
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class SituacaoAjuste {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {
        
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_sit' => ['menu_controller' => 'cadastrar-sit', 'menu_metodo' => 'cad-sit'],
            'vis_sit' => ['menu_controller' => 'ver-sit', 'menu_metodo' => 'ver-sit'],
            'edit_sit' => ['menu_controller' => 'editar-sit', 'menu_metodo' => 'edit-sit'],
            'del_sit' => ['menu_controller' => 'apagar-sit', 'menu_metodo' => 'apagar-sit']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarSit = new \App\adms\Models\AdmsListarSitAjuste();
        $this->Dados['listSit'] = $listarSit->listarSitAjuste($this->PageId);
        $this->Dados['paginacao'] = $listarSit->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/situacaoAj/listarSitAjuste", $this->Dados);
        $carregarView->renderizar();
    }

}
