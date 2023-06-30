<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of BalancoProduto
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class BalancoProduto {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {

        $this->PageId = (int) $PageId ? $PageId : 1;
        $this->Dados['id'] = (int) filter_input(INPUT_GET, "id", FILTER_DEFAULT);

        $botao = ['cad_balanco' => ['menu_controller' => 'cadastrar-balanco-produto', 'menu_metodo' => 'cad-produto'],
            'list_balanco' => ['menu_controller' => 'balanco', 'menu_metodo' => 'listar'],
            'vis_balanco_produto' => ['menu_controller' => 'ver-balanco-produto', 'menu_metodo' => 'ver-balanco'],
            'edit_balanco_produto' => ['menu_controller' => 'editar-balanco-produto', 'menu_metodo' => 'edit-balanco'],
            'del_balanco_produto' => ['menu_controller' => 'apagar-balanco-produto', 'menu_metodo' => 'apagar-balanco']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarSelect = new \App\adms\Models\AdmsListarBalancoProduto();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $listarBalanco = new \App\adms\Models\AdmsListarBalancoProduto();
        $this->Dados['listBalanco'] = $listarBalanco->listarBalanco($this->PageId, $this->Dados);
        $this->Dados['paginacao'] = $listarBalanco->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/auditoria/listarBalancoProdutos", $this->Dados);
        $carregarView->renderizar();
    }

}
