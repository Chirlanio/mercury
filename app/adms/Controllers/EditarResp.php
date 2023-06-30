<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarResp
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarResp {

    private $Dados;
    private $DadosId;

    public function editResp($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editRespPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Responsável não encontrado!</div>";
            $UrlDestino = URLADM . 'autorizacao-resp/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editRespPriv() {
        if (!empty($this->Dados['EditResp'])) {
            unset($this->Dados['EditResp']);
            $editarResp = new \App\adms\Models\AdmsEditarResp();
            $editarResp->altResp($this->Dados);
            if ($editarResp->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Responsável editado com sucesso!</div>";
                $UrlDestino = URLADM . 'autorizacao-resp/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editRespViewPriv();
            }
        } else {
            $verResp = new \App\adms\Models\AdmsEditarResp();
            $this->Dados['form'] = $verResp->verResp($this->DadosId);
            $this->editRespViewPriv();
        }
    }

    private function editRespViewPriv() {
        if ($this->Dados['form']) {
            $listarSelect = new \App\adms\Models\AdmsEditarResp();
            $this->Dados['select'] = $listarSelect->listarCadastrar();
            
            $botao = ['list_resp' => ['menu_controller' => 'autorizacao-resp', 'menu_metodo' => 'listar']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/financeiro/editarResp", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Responsável não encontrado!</div>";
            $UrlDestino = URLADM . 'autorizacao-resp/listar';
            header("Location: $UrlDestino");
        }
    }

}
