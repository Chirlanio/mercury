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

        $botao = ['cad_balanco' => ['menu_controller' => 'cadastrar-balanco-produto', 'menu_metodo' => 'cad-balanco-produto'],
            'vis_balanco' => ['menu_controller' => 'ver-balanco-produto', 'menu_metodo' => 'ver-balanco-produto'],
            'edit_balanco' => ['menu_controller' => 'editar-balanco-produto', 'menu_metodo' => 'edit-balanco-produto'],
            'del_balanco' => ['menu_controller' => 'apagar-balanco-produto', 'menu_metodo' => 'apagar-balanco-produto']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarSelect = new \App\adms\Models\AdmsListarBalancoProduto();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $listarBalanco = new \App\adms\Models\AdmsListarBalancoProduto();
        $this->Dados['listBalanco'] = $listarBalanco->listarBalanco($this->PageId);
        $this->Dados['paginacao'] = $listarBalanco->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/auditoria/listarBalancoProdutos", $this->Dados);
        $carregarView->renderizar();
    }

}
