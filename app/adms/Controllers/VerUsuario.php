<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of VerUsuario
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class VerUsuario {

    private $Dados;
    private $DadosId;

    public function verUsuario($DadosId = null) {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verUsuario = new \App\adms\Models\AdmsVerUsuario();
            $this->Dados['dados_usuario'] = $verUsuario->verUsuario($this->DadosId);

            $botao = ['list_usuario' => ['menu_controller' => 'usuarios', 'menu_metodo' => 'listar'],
                'edit_usuario' => ['menu_controller' => 'editar-usuario', 'menu_metodo' => 'edit-usuario'],
                'edit_senha' => ['menu_controller' => 'editar-senha', 'menu_metodo' => 'edit-senha'],
                'del_usuario' => ['menu_controller' => 'apagar-usuario', 'menu_metodo' => 'apagar-usuario']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/usuario/verUsuario", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Usuário não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'usuarios/listar';
            header("Location: $UrlDestino");
        }
    }

}
