<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Arquivo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class Arquivo {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {

        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_arq' => ['menu_controller' => 'cadastrar-arquivo', 'menu_metodo' => 'cad-arquivo'],
            'edit_arq' => ['menu_controller' => 'editar-arquivo', 'menu_metodo' => 'edit-arquivo'],
            'del_arq' => ['menu_controller' => 'apagar-arquivo', 'menu_metodo' => 'apagar-arquivo']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarArq = new \App\adms\Models\AdmsListarArquivo();
        $this->Dados['listArq'] = $listarArq->listar($this->PageId);
        $this->Dados['paginacao'] = $listarArq->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/upload/arquivo", $this->Dados);
        $carregarView->renderizar();
    }

}
