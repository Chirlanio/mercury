<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ProcessLibrary
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ProcessLibrary {

    private $Dados;
    private $PageId;

    public function list($PageId = null) {

        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['add_process' => ['menu_controller' => 'add-process-library', 'menu_metodo' => 'add-process'],
            'view_process' => ['menu_controller' => 'view-process', 'menu_metodo' => 'view-process'],
            'edit_process' => ['menu_controller' => 'edit-process', 'menu_metodo' => 'edit-process'],
            'del_process' => ['menu_controller' => 'delete-artigo', 'menu_metodo' => 'delete-process']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listProcess = new \App\adms\Models\AdmsListProcessLibrary();
        $this->Dados['listProcess'] = $listProcess->list($this->PageId);
        $this->Dados['paginacao'] = $listProcess->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/biblioteca/processLibrary", $this->Dados);
        $carregarView->renderizar();
    }

}
