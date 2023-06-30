<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Usuarios
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class Usuarios {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_usuario' => ['menu_controller' => 'cadastrar-usuario', 'menu_metodo' => 'cad-usuario'],
            'vis_usuario' => ['menu_controller' => 'ver-usuario', 'menu_metodo' => 'ver-usuario'],
            'edit_usuario' => ['menu_controller' => 'editar-usuario', 'menu_metodo' => 'edit-usuario'],
            'del_usuario' => ['menu_controller' => 'apagar-usuario', 'menu_metodo' => 'apagar-usuario']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarUsario = new \App\adms\Models\AdmsListarUsuario();
        $this->Dados['listUser'] = $listarUsario->listarUsuario($this->PageId);
        $this->Dados['paginacao'] = $listarUsario->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/usuario/listarUsuario", $this->Dados);
        $carregarView->renderizar();
    }

}
