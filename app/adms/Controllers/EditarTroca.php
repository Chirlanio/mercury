<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarSit
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarTroca {

    private $Dados;
    private $DadosId;

    public function editTroca($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editTrocaPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Solicitação não encontrada!</div>";
            $UrlDestino = URLADM . 'troca/listarTroca';
            header("Location: $UrlDestino");
        }
    }

    private function editTrocaPriv() {
        if (!empty($this->Dados['EditTroca'])) {
            unset($this->Dados['EditTroca']);
            $editarTroca = new \App\adms\Models\AdmsEditarTroca();
            $editarTroca->altTroca($this->Dados);
            if ($editarTroca->getResultado()) {
                $UrlDestino = URLADM . 'listar-troca/listar-troca/';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editTrocaViewPriv();
            }
        } else {
            $verTroca = new \App\adms\Models\AdmsEditarTroca();
            $this->Dados['form'] = $verTroca->verTroca($this->DadosId);
            $this->editTrocaViewPriv();
        }
    }

    private function editTrocaViewPriv() {
        if ($this->Dados['form']) {
            $listarSelect = new \App\adms\Models\AdmsEditarTroca();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['vis_troca' => ['menu_controller' => 'listar-troca', 'menu_metodo' => 'listar-troca']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/troca/editarTroca", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não é permitido alterar solicitações com o status \"Cadastrado\"!</div>";
            $UrlDestino = URLADM . 'listar-troca/listar-troca';
            header("Location: $UrlDestino");
        }
    }

}
