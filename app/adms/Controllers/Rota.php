<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Rota
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class Rota {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {
        
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_rota' => ['menu_controller' => 'cadastrar-rota', 'menu_metodo' => 'cad-rota'],
            'vis_rota' => ['menu_controller' => 'ver-rota', 'menu_metodo' => 'ver-rota'],
            'edit_rota' => ['menu_controller' => 'editar-rota', 'menu_metodo' => 'edit-rota'],
            'del_rota' => ['menu_controller' => 'apagar-rota', 'menu_metodo' => 'apagar-rota']];
        
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarRota = new \App\adms\Models\AdmsListarRota();
        $this->Dados['listRota'] = $listarRota->listarRota($this->PageId);
        $this->Dados['paginacao'] = $listarRota->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/rota/listarRota", $this->Dados);
        $carregarView->renderizar();
    }

}
