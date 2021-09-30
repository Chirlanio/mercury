<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Autorizar
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class Autorizar {

    private $Dados;
    private $PageId;
    private $Resp;

    public function listar($PageId = null) {
        $this->PageId = (int) $PageId ? $PageId : 1;
        $this->Dados['pg'] = $this->PageId;
        $this->Resp = filter_input(INPUT_GET, "resp", FILTER_SANITIZE_NUMBER_INT);

        $botao = ['list_resp' => ['menu_controller' => 'autorizacao-resp', 'menu_metodo' => 'listar'],
            'libe_resp' => ['menu_controller' => 'lib_resp', 'menu_metodo' => 'lib_resp'],
            'edit_resp' => ['menu_controller' => 'editar-resp', 'menu_metodo' => 'edit-resp'],
            'lib_resp' => ['menu_controller' => 'lib-resp', 'menu_metodo' => 'lib-resp']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarResp = new \App\adms\Models\AdmsListarAutoResp();
        $this->Dados['listResp'] = $listarResp->listar($this->PageId, $this->Resp);
        $this->Dados['paginacao'] = $listarResp->getResultadoPg();

        $this->Dados['dados_auto'] = $listarResp->verResp($this->Resp);

        $carregarView = new \Core\ConfigView("adms/Views/financeiro/listarAutorizacoes", $this->Dados);
        $carregarView->renderizar();
    }

}
