<?php

namespace App\cpadms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarUsuarioModal
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarUsuarioModal {

    private $Dados;
    private $DadosId;

    public function editUsuario($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        //var_dump($this->DadosId);
        if (!empty($this->DadosId)) {
            $this->editUsuarioPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Usuário não encontrado!</div>";
            $UrlDestino = URLADM . 'carregar-usuario-js/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editUsuarioPriv() {
        if (!empty($this->Dados['EditUsuario'])) {
            unset($this->Dados['EditUsuario']);

            $this->Dados['imagem_nova'] = ($_FILES['imagem_nova'] ? $_FILES['imagem_nova'] : null);
            $editarUsuario = new \App\cpadms\Models\CpAdmsEditarUsuario();
            $editarUsuario->altUsuario($this->Dados);

            if ($editarUsuario->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Usuário editado com sucesso!</div>";
                $UrlDestino = URLADM . 'carregar-usuario-js/listar/';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editUsuarioViewPriv();
            }
        } else {
            $verUsuario = new \App\cpadms\Models\CpAdmsEditarUsuario();
            $this->Dados['form'] = $verUsuario->verUsuario($this->DadosId);
            $this->editUsuarioViewPriv();
        }
    }

    private function editUsuarioViewPriv() {
        if ($this->Dados['form']) {
            $listarSelect = new \App\cpadms\Models\CpAdmsEditarUsuario();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $carregarView = new \App\cpadms\core\ConfigView("cpadms/Views/usuario/editarUsuarioJs", $this->Dados);
            $carregarView->renderizarListar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Usuário não encontrado!</div>";
            $UrlDestino = URLADM . 'carregar-usuarios-js/listar';
            header("Location: $UrlDestino");
        }
    }

}
