<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Balanco
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class Balanco {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {

        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_balanco' => ['menu_controller' => 'cadastrar-balanco', 'menu_metodo' => 'cad-balanco'],
            'list_produto' => ['menu_controller' => 'balanco-produto', 'menu_metodo' => 'listar'],
            'vis_balanco' => ['menu_controller' => 'ver-balanco', 'menu_metodo' => 'ver-balanco'],
            'edit_balanco' => ['menu_controller' => 'editar-balanco', 'menu_metodo' => 'edit-balanco'],
            'del_balanco' => ['menu_controller' => 'apagar-balanco', 'menu_metodo' => 'apagar-balanco']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarSelect = new \App\adms\Models\AdmsListarBalanco();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $listarBalanco = new \App\adms\Models\AdmsListarBalanco();
        $this->Dados['listBalanco'] = $listarBalanco->listarBalanco($this->PageId);
        $this->Dados['paginacao'] = $listarBalanco->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/auditoria/listarBalanco", $this->Dados);
        $carregarView->renderizar();
    }

}
