<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of TipoArtigo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class TipoArtigo {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {

        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_tipo' => ['menu_controller' => 'cadastrar-tipo', 'menu_metodo' => 'cad-tipo'],
            'vis_tipo' => ['menu_controller' => 'ver-tipo', 'menu_metodo' => 'ver-tipo'],
            'edit_tipo' => ['menu_controller' => 'editar-tipo', 'menu_metodo' => 'edit-tipo'],
            'del_tipo' => ['menu_controller' => 'apagar-tipo', 'menu_metodo' => 'apagar-tipo']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarTipo = new \App\adms\Models\AdmsListarTipoArt();
        $this->Dados['listTipo'] = $listarTipo->listar($this->PageId);
        $this->Dados['paginacao'] = $listarTipo->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/tipoArt/listarTipo", $this->Dados);
        $carregarView->renderizar();
    }

}
