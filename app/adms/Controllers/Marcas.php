<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Marcas
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class Marcas {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {
        
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_marca' => ['menu_controller' => 'cadastrar-marca', 'menu_metodo' => 'cad-marca'],
            'vis_marca' => ['menu_controller' => 'ver-marca', 'menu_metodo' => 'ver-marca'],
            'edit_marca' => ['menu_controller' => 'editar-marca', 'menu_metodo' => 'edit-marca'],
            'del_marca' => ['menu_controller' => 'apagar-marca', 'menu_metodo' => 'apagar-marca']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        /*$listarSelect = new \App\adms\Models\AdmsListarMarca();
        $this->Dados['select'] = $listarSelect->listarCadastrar();*/

        $listarMarca = new \App\adms\Models\AdmsListarMarca();
        $this->Dados['listMarca'] = $listarMarca->listarMarca($this->PageId);
        $this->Dados['paginacao'] = $listarMarca->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/marca/listarMarca", $this->Dados);
        $carregarView->renderizar();
    }

}
