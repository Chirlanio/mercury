<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Estorno
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class Estorno {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {

        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_estorno' => ['menu_controller' => 'cadastrar-estorno', 'menu_metodo' => 'cad-estorno'],
            'vis_estorno' => ['menu_controller' => 'ver-estorno', 'menu_metodo' => 'ver-estorno'],
            'edit_estorno' => ['menu_controller' => 'editar-estorno', 'menu_metodo' => 'edit-estorno'],
            'del_estorno' => ['menu_controller' => 'apagar-estorno', 'menu_metodo' => 'apagar-estorno']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        
        $listarSelect = new \App\adms\Models\AdmsListarEstorno();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $listarEstorno = new \App\adms\Models\AdmsListarEstorno();
        $this->Dados['list_estorno'] = $listarEstorno->listar($this->PageId);
        $this->Dados['paginacao'] = $listarEstorno->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/estorno/listarEstorno", $this->Dados);
        $carregarView->renderizar();
    }

}
