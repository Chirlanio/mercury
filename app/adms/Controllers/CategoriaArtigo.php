<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CategoriaArtigo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CategoriaArtigo {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {

        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_cat' => ['menu_controller' => 'cadastrar-cat', 'menu_metodo' => 'cad-cat'],
            'vis_cat' => ['menu_controller' => 'ver-cat', 'menu_metodo' => 'ver-cat'],
            'edit_cat' => ['menu_controller' => 'editar-cat', 'menu_metodo' => 'edit-cat'],
            'del_cat' => ['menu_controller' => 'apagar-cat', 'menu_metodo' => 'apagar-cat']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarCat = new \App\adms\Models\AdmsListarCatArt();
        $this->Dados['listCat'] = $listarCat->listar($this->PageId);
        $this->Dados['paginacao'] = $listarCat->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/catArt/listarCat", $this->Dados);
        $carregarView->renderizar();
    }

}
