<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ListarArquivo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ListarArquivo {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {

        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_arq' => ['menu_controller' => 'cadastrar-arq', 'menu_metodo' => 'cad-arq'],
            'edit_arq' => ['menu_controller' => 'editar-arq', 'menu_metodo' => 'edit-arq'],
            'del_arq' => ['menu_controller' => 'apagar-arq', 'menu_metodo' => 'apagar-arq']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarArq = new \App\adms\Models\AdmsListarArq();
        $this->Dados['listArq'] = $listarArq->listar($this->PageId);
        $this->Dados['paginacao'] = $listarArq->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/upload/arquivo", $this->Dados);
        $carregarView->renderizar();
    }

}
