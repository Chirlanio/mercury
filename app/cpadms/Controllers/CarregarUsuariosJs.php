<?php

namespace App\cpadms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CarregarUsuariosJs
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CarregarUsuariosJs {

    private $Dados;
    private $PageId;
    private $TipoResultado;

    public function listar($PageId = null) {
        $this->TipoResultado = filter_input(INPUT_GET, 'tiporesult');
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_usuario' => ['menu_controller' => 'cadastrar-usuario', 'menu_metodo' => 'cad-usuario'],
            'vis_usuario' => ['menu_controller' => 'ver-usuario', 'menu_metodo' => 'ver-usuario'],
            'edit_usuario' => ['menu_controller' => 'editar-usuario', 'menu_metodo' => 'edit-usuario'],
            'del_usuario' => ['menu_controller' => 'apagar-usuario', 'menu_metodo' => 'apagar-usuario']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        if (!empty($this->TipoResultado) AND ( $this->TipoResultado == 1)) {
            $this->listarUsuariosPriv();
        } else {
            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \App\cpadms\core\ConfigView("cpadms/Views/usuario/carregarUsuariosJs", $this->Dados);
            $carregarView->renderizar();
        }
    }

    private function listarUsuariosPriv() {
        $listarUsario = new \App\cpadms\Models\CpAdmsListarUsuario();
        $this->Dados['listUser'] = $listarUsario->listarUsuario($this->PageId);
        $this->Dados['paginacao'] = $listarUsario->getResultadoPg();

        $carregarView = new \App\cpadms\core\ConfigView("cpadms/Views/usuario/listarUsuarioJs", $this->Dados);
        $carregarView->renderizarListar();
    }

}
