<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarTipo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarTipo {

    private $Dados;
    private $DadosId;

    public function editTipo($DadosId = null) {

        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $this->DadosId = (int) $DadosId;

        if (!empty($this->DadosId)) {
            $this->editTipoPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Tipo de artigo não encontrado!</div>";
            $UrlDestino = URLADM . 'tipo-artigo/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editTipoPriv() {
        if (!empty($this->Dados['EditTipo'])) {
            unset($this->Dados['EditTipo']);
            $editarTipo = new \App\adms\Models\AdmsEditarTipoArt();
            $editarTipo->altTipo($this->Dados);
            if ($editarTipo->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Tipo de artigo editado com sucesso!</div>";
                $UrlDestino = URLADM . 'tipo-artigo/listar/';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editTipoViewPriv();
            }
        } else {
            $verTipo = new \App\adms\Models\AdmsEditarTipoArt();
            $this->Dados['form'] = $verTipo->verTipo($this->DadosId);
            $this->editTipoViewPriv();
        }
    }

    private function editTipoViewPriv() {
        if ($this->Dados['form']) {

            $botao = ['list_tipo' => ['menu_controller' => 'tipo-artigo', 'menu_metodo' => 'listar']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/tipoArt/editarTipo", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Tipo de artigo não encontrado!</div>";
            $UrlDestino = URLADM . 'tipo-artigo/listar';
            header("Location: $UrlDestino");
        }
    }

}
