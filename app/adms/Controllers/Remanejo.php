<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Remanejo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class Remanejo {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {
        
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_remanejo' => ['menu_controller' => 'cadastrar-remanejo', 'menu_metodo' => 'cad-remanejo'],
            'vis_remanejo' => ['menu_controller' => 'ver-remanejo', 'menu_metodo' => 'ver-remanejo'],
            'edit_remanejo' => ['menu_controller' => 'editar-remanejo', 'menu_metodo' => 'edit-remanejo'],
            'del_remanejo' => ['menu_controller' => 'apagar-remanejo', 'menu_metodo' => 'apagar-remanejo']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarSelect = new \App\adms\Models\AdmsListarRemanejo();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $listarRemanejo = new \App\adms\Models\AdmsListarRemanejo();
        $this->Dados['listRemanejo'] = $listarRemanejo->listarRemanejo($this->PageId);
        $this->Dados['paginacao'] = $listarRemanejo->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/remanejo/listarRemanejo", $this->Dados);
        $carregarView->renderizar();
    }

}
