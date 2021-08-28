<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Cargo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class Cargo {

    private $Dados;
    private $PageId;

    public function listarCargo($PageId = null) {
        
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_cargo' => ['menu_controller' => 'cadastrar-cargo', 'menu_metodo' => 'cad-cargo'],
            'vis_cargo' => ['menu_controller' => 'ver-cargo', 'menu_metodo' => 'ver-cargo'],
            'edit_cargo' => ['menu_controller' => 'editar-cargo', 'menu_metodo' => 'edit-cargo'],
            'del_cargo' => ['menu_controller' => 'apagar-cargo', 'menu_metodo' => 'apagar-cargo']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarCargo = new \App\adms\Models\AdmsListarCargo();
        $this->Dados['listCargo'] = $listarCargo->listarCargo($this->PageId);
        $this->Dados['paginacao'] = $listarCargo->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/cargo/listarCargo", $this->Dados);
        $carregarView->renderizar();
    }

}
