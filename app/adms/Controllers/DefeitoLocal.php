<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of DefeitoLocal
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class DefeitoLocal {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {
        
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_def_local' => ['menu_controller' => 'cadastrar-defeito-local', 'menu_metodo' => 'cad-defeito-local'],
            'vis_def_local' => ['menu_controller' => 'ver-defeito-local', 'menu_metodo' => 'ver-defeito-local'],
            'edit_def_local' => ['menu_controller' => 'editar-defeito-local', 'menu_metodo' => 'edit-defeito-local'],
            'del_def_local' => ['menu_controller' => 'apagar-defeito-local', 'menu_metodo' => 'apagar-defeito-local']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarDefLocal = new \App\adms\Models\AdmsListarDefeitoLocal();
        $this->Dados['listDefLocal'] = $listarDefLocal->listarDefeitoLocal($this->PageId);
        $this->Dados['paginacao'] = $listarDefLocal->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/defeitoLocal/listarDefLocal", $this->Dados);
        $carregarView->renderizar();
    }

}
