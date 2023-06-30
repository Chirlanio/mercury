<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Detalhes
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class Detalhes {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {
        
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_detalhes' => ['menu_controller' => 'cadastrar-detalhes', 'menu_metodo' => 'cad-detalhes'],
            'vis_detalhes' => ['menu_controller' => 'ver-detalhes', 'menu_metodo' => 'ver-detalhes'],
            'edit_detalhes' => ['menu_controller' => 'editar-detalhes', 'menu_metodo' => 'edit-detalhes'],
            'del_detalhes' => ['menu_controller' => 'apagar-detalhes', 'menu_metodo' => 'apagar-detalhes']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarDetalhes = new \App\adms\Models\AdmsListarDetalhes();
        $this->Dados['listDetalhes'] = $listarDetalhes->listarDetalhes($this->PageId);
        $this->Dados['paginacao'] = $listarDetalhes->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/detalhes/listarDetalhes", $this->Dados);
        $carregarView->renderizar();
    }

}
