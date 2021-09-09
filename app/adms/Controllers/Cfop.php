<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Cfop
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class Cfop {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {
        
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_cfop' => ['menu_controller' => 'cadastrar-cfop', 'menu_metodo' => 'cad-cfop'],
            'vis_cfop' => ['menu_controller' => 'ver-cfop', 'menu_metodo' => 'ver-cfop'],
            'edit_cfop' => ['menu_controller' => 'editar-cfop', 'menu_metodo' => 'edit-cfop'],
            'del_cfop' => ['menu_controller' => 'apagar-cfop', 'menu_metodo' => 'apagar-cfop']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarCfop = new \App\adms\Models\AdmsListarCfop();
        $this->Dados['listCfop'] = $listarCfop->listar($this->PageId);
        $this->Dados['paginacao'] = $listarCfop->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/faq/listarCfop", $this->Dados);
        $carregarView->renderizar();
    }

}
