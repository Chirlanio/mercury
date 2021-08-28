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
class Bairro {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {
        
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_bairro' => ['menu_controller' => 'cadastrar-bairro', 'menu_metodo' => 'cad-bairro'],
            'vis_bairro' => ['menu_controller' => 'ver-bairro', 'menu_metodo' => 'ver-bairro'],
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
