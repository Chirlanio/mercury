<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarUsuario
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarUsuario
{

    private $Dados;
    private $DadosId;

    public function editUsuario($DadosId = null)
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editUsuarioPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Usuário não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'usuarios/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editUsuarioPriv()
    {
        if (!empty($this->Dados['EditUsuario'])) {
            unset($this->Dados['EditUsuario']);
            
            $this->Dados['imagem_nova'] = ($_FILES['imagem_nova'] ? $_FILES['imagem_nova'] : null);
            
            $editarUsuario = new \App\adms\Models\AdmsEditarUsuario();
            $editarUsuario->altUsuario($this->Dados);
            
            if ($editarUsuario->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Usuário</strong> atualizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $UrlDestino = URLADM . 'ver-usuario/ver-usuario/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editUsuarioViewPriv();
            }
        } else {
            $verUsuario = new \App\adms\Models\AdmsEditarUsuario();
            $this->Dados['form'] = $verUsuario->verUsuario($this->DadosId);
            $this->editUsuarioViewPriv();
        }
    }

    private function editUsuarioViewPriv()
    {
        if ($this->Dados['form']) {
            $listarSelect = new \App\adms\Models\AdmsEditarUsuario();
            $this->Dados['select'] = $listarSelect->listAdd();
            
            $botao = ['list_usuario' => ['menu_controller' => 'usuarios', 'menu_metodo' => 'listar'], 'vis_usuario' => ['menu_controller' => 'ver-usuario', 'menu_metodo' => 'ver-usuario']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/usuario/editarUsuario", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Usuário não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'usuarios/listar';
            header("Location: $UrlDestino");
        }
    }

}
