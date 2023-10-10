<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Bairro
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class Areas {

    private $Dados;
    private $PageId;

    public function list($PageId = null) {
        
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['add_areas' => ['menu_controller' => 'add-areas', 'menu_metodo' => 'add-area'],
            'view_areas' => ['menu_controller' => 'view-areas', 'menu_metodo' => 'view-areas'],
            'edit_bairro' => ['menu_controller' => 'editar-bairro', 'menu_metodo' => 'edit-bairro'],
            'del_bairro' => ['menu_controller' => 'apagar-bairro', 'menu_metodo' => 'apagar-bairro']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarBairro = new \App\adms\Models\AdmsListarBairro();
        $this->Dados['listBairro'] = $listarBairro->listarBairro($this->PageId);
        $this->Dados['paginacao'] = $listarBairro->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/bairro/listarBairro", $this->Dados);
        $carregarView->renderizar();
    }

}
