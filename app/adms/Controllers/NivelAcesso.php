<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of NivelAcesso
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class NivelAcesso {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_nivac' => ['menu_controller' => 'cadastrar-niv-ac', 'menu_metodo' => 'cad-niv-ac'],
            'vis_nivac' => ['menu_controller' => 'ver-niv-ac', 'menu_metodo' => 'ver-niv-ac'],
            'edit_nivac' => ['menu_controller' => 'editar-niv-ac', 'menu_metodo' => 'edit-niv-ac'],
            'del_nivac' => ['menu_controller' => 'apagar-niv-ac', 'menu_metodo' => 'apagar-niv-ac'],
            'ordem_nivac' => ['menu_controller' => 'alt-ordem-niv-ac', 'menu_metodo' => 'alt-ordem-niv-ac'],
            'list_permi' => ['menu_controller' => 'permissoes', 'menu_metodo' => 'listar'],
            'sincro_permi' => ['menu_controller' => 'sincro-pg-niv-ac', 'menu_metodo' => 'sincro-pg-niv-ac']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarNivAc = new \App\adms\Models\AdmsListarNivAc();
        $this->Dados['listNivAc'] = $listarNivAc->listarNivAc($this->PageId);
        $this->Dados['paginacao'] = $listarNivAc->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/nivAcesso/listarNicAc", $this->Dados);
        $carregarView->renderizar();
    }

}
