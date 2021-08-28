<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Funcionarios
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class Funcionarios {

    private $Dados;
    private $PageId;

    public function listarFunc($PageId = null) {
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['listFunc' => ['menu_controller' => 'cadastrar-func', 'menu_metodo' => 'cad-func'],
            'vis_func' => ['menu_controller' => 'ver-func', 'menu_metodo' => 'ver-func'],
            'edit_func' => ['menu_controller' => 'editar-func', 'menu_metodo' => 'edit-func'],
            'del_func' => ['menu_controller' => 'apagar-func', 'menu_metodo' => 'apagar-func']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarSelect = new \App\adms\Models\AdmsListarFunc();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $listarFunc = new \App\adms\Models\AdmsListarFunc();
        $this->Dados['listFunc'] = $listarFunc->listarFunc($this->PageId);
        $this->Dados['paginacao'] = $listarFunc->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/funcionarios/listarFunc", $this->Dados);
        $carregarView->renderizar();
    }

}
