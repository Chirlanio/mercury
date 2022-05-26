<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Ciclos
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class Ciclos {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {
        
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_ciclo' => ['menu_controller' => 'cadastrar-ciclo', 'menu_metodo' => 'cad-ciclo'],
            'vis_ciclo' => ['menu_controller' => 'ver-ciclo', 'menu_metodo' => 'ver-ciclo'],
            'edit_ciclo' => ['menu_controller' => 'editar-ciclo', 'menu_metodo' => 'edit-ciclo'],
            'del_ciclo' => ['menu_controller' => 'apagar-ciclo', 'menu_metodo' => 'apagar-ciclo']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarCiclos = new \App\adms\Models\AdmsListarCiclos();
        $this->Dados['listCiclo'] = $listarCiclos->listarCiclos($this->PageId);
        $this->Dados['paginacao'] = $listarCiclos->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/ciclo/listarCiclo", $this->Dados);
        $carregarView->renderizar();
    }

}
