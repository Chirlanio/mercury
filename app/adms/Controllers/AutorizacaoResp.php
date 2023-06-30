<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AutorizacaoResp
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AutorizacaoResp {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_resp' => ['menu_controller' => 'cadastrar-resp', 'menu_metodo' => 'cad-resp'],
            'edit_resp' => ['menu_controller' => 'editar-resp', 'menu_metodo' => 'edit-resp'],
            'del_resp' => ['menu_controller' => 'apagar-resp', 'menu_metodo' => 'apagar-resp'],
            'list_resp' => ['menu_controller' => 'permissoes', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarResp = new \App\adms\Models\AdmsListarResp();
        $this->Dados['listResp'] = $listarResp->listarResp($this->PageId);
        $this->Dados['paginacao'] = $listarResp->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/financeiro/listarResp", $this->Dados);
        $carregarView->renderizar();
    }

}
