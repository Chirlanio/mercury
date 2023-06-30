<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of UsuariosTreinamento
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class UsuariosTreinamento {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_usuario' => ['menu_controller' => 'cadastrar-usuario-treinamento', 'menu_metodo' => 'cad-usuario'],
            'vis_usuario' => ['menu_controller' => 'ver-usuario-treinamento', 'menu_metodo' => 'ver-usuario'],
            'edit_usuario' => ['menu_controller' => 'editar-usuario-treinamento', 'menu_metodo' => 'edit-usuario'],
            'del_usuario' => ['menu_controller' => 'apagar-usuario-treinamento', 'menu_metodo' => 'apagar-usuario']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarUsuario = new \App\adms\Models\AdmsListarUsuarioTreinamento();
        $this->Dados['listUser'] = $listarUsuario->listarUsuario($this->PageId);
        $this->Dados['paginacao'] = $listarUsuario->getResultadoPg();

        $carregarView = new \Core\ConfigView("adms/Views/usuarioTreinamento/listarUsuario", $this->Dados);
        $carregarView->renderizar();
    }

}
