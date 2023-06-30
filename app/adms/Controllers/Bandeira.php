<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Bandeira
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class Bandeira {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {
        
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_bandeira' => ['menu_controller' => 'cadastrar-bandeira', 'menu_metodo' => 'cad-bandeira'],
            'vis_bandeira' => ['menu_controller' => 'ver-bandeira', 'menu_metodo' => 'ver-bandeira'],
            'edit_bandeira' => ['menu_controller' => 'editar-bandeira', 'menu_metodo' => 'edit-bandeira'],
            'del_bandeira' => ['menu_controller' => 'apagar-bandeira', 'menu_metodo' => 'apagar-bandeira']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarBandeira = new \App\adms\Models\AdmsListarBandeira();
        $this->Dados['listBandeira'] = $listarBandeira->listarBandeira($this->PageId);
        $this->Dados['paginacao'] = $listarBandeira->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/bandeira/listarBandeira", $this->Dados);
        $carregarView->renderizar();
    }

}
