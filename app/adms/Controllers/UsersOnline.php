<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of UsersOnline
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class UsersOnline {

    private $Dados;
    private $PageId;

    public function list($PageId = null) {
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['logout' => ['menu_controller' => 'login', 'menu_metodo' => 'logout'],
            'vis_usuario' => ['menu_controller' => 'ver-usuario', 'menu_metodo' => 'ver-usuario'],
            'edit_usuario' => ['menu_controller' => 'editar-usuario', 'menu_metodo' => 'edit-usuario'],
            'del_usuario' => ['menu_controller' => 'apagar-usuario', 'menu_metodo' => 'apagar-usuario']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listUserOnline = new \App\adms\Models\AdmsListarUsuario();
        $this->Dados['listUserOnline'] = $listUserOnline->usersOnline($this->PageId);
        $this->Dados['pagination'] = $listUserOnline->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/usuario/listUsersOnline", $this->Dados);
        $carregarView->renderizar();
    }

}
