<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of SituacaoTransf
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class SituacaoTransf {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {
        
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_sit' => ['menu_controller' => 'cadastrar-sit-transf', 'menu_metodo' => 'cad-sit'],
            'vis_sit' => ['menu_controller' => 'ver-sit-transf', 'menu_metodo' => 'ver-sit'],
            'edit_sit' => ['menu_controller' => 'editar-sit-transf', 'menu_metodo' => 'edit-sit'],
            'del_sit' => ['menu_controller' => 'apagar-sit-transf', 'menu_metodo' => 'apagar-sit']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarSit = new \App\adms\Models\AdmsListarSitTransf();
        $this->Dados['listSit'] = $listarSit->listarSit($this->PageId);
        $this->Dados['paginacao'] = $listarSit->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/situacaoTransf/listarSit", $this->Dados);
        $carregarView->renderizar();
    }

}
