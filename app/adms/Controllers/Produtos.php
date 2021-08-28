<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Produtos
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class Produtos {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {
        
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['list_produtos' => ['menu_controller' => 'produtos', 'menu_metodo' => 'listar'],
            'vis_produtos' => ['menu_controller' => 'ver-produto', 'menu_metodo' => 'ver-produto'],
            'edit_produtos' => ['menu_controller' => 'editar-produto', 'menu_metodo' => 'edit-produto'],
            'del_produtos' => ['menu_controller' => 'apagar-produto', 'menu_metodo' => 'apagar-produto']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarProdutos = new \App\adms\Models\AdmsListarProdutos();
        $this->Dados['listProdutos'] = $listarProdutos->listarProdutos($this->PageId);
        $this->Dados['paginacao'] = $listarProdutos->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/produtos/listarProdutos", $this->Dados);
        $carregarView->renderizar();
    }

}
