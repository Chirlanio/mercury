<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarSenhaTreinamento
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarSenhaTreinamento {

    private $Dados;
    private $DadosId;

    public function editSenha($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $validaUsuario = new \App\adms\Models\AdmsEditarSenhaTreinamento();
            $validaUsuario->valUsuario($this->DadosId);
            if ($validaUsuario->getResultado()) {
                $this->editSenhaPriv();
            } else {
                $UrlDestino = URLADM . 'usuarios-treinamento/listar';
                header("Location: $UrlDestino");
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Usuário não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'usuarios-treinamento/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editSenhaPriv() {
        if (!empty($this->Dados['EditSenha'])) {
            unset($this->Dados['EditSenha']);
            $editarSenha = new \App\adms\Models\AdmsEditarSenhaTreinamento();
            $editarSenha->editSenha($this->Dados);
            if ($editarSenha->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Senha</strong> editada com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $UrlDestino = URLADM . 'ver-usuario-treinamento/ver-usuario/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados['id'];
                $this->editSenhaViewPriv();
            }
        } else {
            $this->Dados['form'] = $this->DadosId;
            $this->editSenhaViewPriv();
        }
    }

    private function editSenhaViewPriv() {
        if ($this->Dados['form']) {
            $botao = ['vis_usuario' => ['menu_controller' => 'ver-usuario-treinamento', 'menu_metodo' => 'ver-usuario']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/usuarioTreinamento/editarSenha", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Usuário não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'usuarios-treinamento/listar';
            header("Location: $UrlDestino");
        }
    }

}
