<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Transferencia
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class Transferencia {

    private $Dados;
    private $PageId;

    public function listarTransf($PageId = null) {
        $this->PageId = (int) $PageId ? $PageId : 1;
        $this->Dados['pg'] = $this->PageId;

        $botao = ['list_transf' => ['menu_controller' => 'cadastrar-transf', 'menu_metodo' => 'cad-transf'],
            'vis_transf' => ['menu_controller' => 'ver-transf', 'menu_metodo' => 'ver-transf'],
            'edit_transf' => ['menu_controller' => 'editar-transf', 'menu_metodo' => 'edit-transf'],
            'del_transf' => ['menu_controller' => 'apagar-transf', 'menu_metodo' => 'apagar-transf']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarSelect = new \App\adms\Models\AdmsListarTransferencia();
        $this->Dados['select'] = $listarSelect->listarCadastrar();
        
        $listarTransf = new \App\adms\Models\AdmsListarTransferencia();
        $this->Dados['list_transf'] = $listarTransf->listarTransf($this->PageId);
        $this->Dados['paginacao'] = $listarTransf->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/transferencia/listarTransf", $this->Dados);
        $carregarView->renderizar();
    }

}
