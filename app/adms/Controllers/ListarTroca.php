<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ListarTroca
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ListarTroca {

    private $Dados;
    private $PageId;

    public function listarTroca($PageId = null) {
        
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_troca' => ['menu_controller' => 'cadastrar-troca', 'menu_metodo' => 'cad-troca'],
            'vis_troca' => ['menu_controller' => 'ver-troca', 'menu_metodo' => 'ver-troca'],
            'edit_troca' => ['menu_controller' => 'editar-troca', 'menu_metodo' => 'edit-troca'],
            'del_troca' => ['menu_controller' => 'apagar-troca', 'menu_metodo' => 'apagar-troca']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        
        $listarSelect = new \App\adms\Models\AdmsListarTroca();
        $this->Dados['select']=$listarSelect->listarCadastrar();

        $listarTroca = new \App\adms\Models\AdmsListarTroca();
        $this->Dados['listTroca'] = $listarTroca->listarTroca($this->PageId);
        $this->Dados['paginacao'] = $listarTroca->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/troca/listarTroca", $this->Dados);
        $carregarView->renderizar();
    }

}
