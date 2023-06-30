<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Artigo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class Artigo {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {

        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_artigo' => ['menu_controller' => 'cadastrar-artigo', 'menu_metodo' => 'cad-artigo'],
            'vis_artigo' => ['menu_controller' => 'ver-artigo', 'menu_metodo' => 'ver-artigo'],
            'edit_artigo' => ['menu_controller' => 'editar-artigo', 'menu_metodo' => 'edit-artigo'],
            'del_artigo' => ['menu_controller' => 'apagar-artigo', 'menu_metodo' => 'apagar-artigo']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarAjuste = new \App\adms\Models\AdmsListarArtigo();
        $this->Dados['listArtigo'] = $listarAjuste->listar($this->PageId);
        $this->Dados['paginacao'] = $listarAjuste->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/artigo/listarArtigo", $this->Dados);
        $carregarView->renderizar();
    }

}
