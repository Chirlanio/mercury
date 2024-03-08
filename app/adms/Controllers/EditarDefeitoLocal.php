<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarDefeitoLocal
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarDefeitoLocal {

    private $Dados;
    private $DadosId;

    public function editDefeitoLocal($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editDefeitoLocalPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Registro não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'defeito-local/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editDefeitoLocalPriv() {
        if (!empty($this->Dados['EditDefLocal'])) {
            unset($this->Dados['EditDefLocal']);
            $editarDefeitos = new \App\adms\Models\AdmsEditarDefeitoLocal();
            $editarDefeitos->altDefeitoLocal($this->Dados);
            if ($editarDefeitos->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Cadastro</strong> atualizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $UrlDestino = URLADM . 'ver-defeito-local/ver-defeito-local/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editDefeitoLocalViewPriv();
            }
        } else {
            $verDash = new \App\adms\Models\AdmsEditarDefeitoLocal();
            $this->Dados['form'] = $verDash->verDefeitoLocal($this->DadosId);
            $this->editDefeitoLocalViewPriv();
        }
    }

    private function editDefeitoLocalViewPriv() {
        if ($this->Dados['form']) {
            $listarSelect = new \App\adms\Models\AdmsEditarDefeitoLocal();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['list_def_local' => ['menu_controller' => 'defeito-local', 'menu_metodo' => 'listar'], 'vis_def_local' => ['menu_controller' => 'ver-defeito-local', 'menu_metodo' => 'ver-defeito-local']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/defeitoLocal/editarDefLocal", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Registro não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'defeito-local/listar';
            header("Location: $UrlDestino");
        }
    }
}
