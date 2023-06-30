<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Lojas
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class Lojas {

    private $Dados;
    private $PageId;

    public function listarLojas($PageId = null) {
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_loja' => ['menu_controller' => 'cadastrar-loja', 'menu_metodo' => 'cad-loja'],
            'vis_loja' => ['menu_controller' => 'ver-loja', 'menu_metodo' => 'ver-loja'],
            'edit_loja' => ['menu_controller' => 'editar-loja', 'menu_metodo' => 'edit-loja'],
            'del_loja' => ['menu_controller' => 'apagar-loja', 'menu_metodo' => 'apagar-loja']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarLoja = new \App\adms\Models\AdmsListarLojas();
        $this->Dados['listLoja'] = $listarLoja->listarLojas($this->PageId);
        $this->Dados['paginacao'] = $listarLoja->getResultadoLj();

        $carregarView = new \Core\ConfigView("adms/Views/loja/listarLojas", $this->Dados);
        $carregarView->renderizar();
    }

}
