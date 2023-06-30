<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarDefeitos
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarDefeitos {

    private $Dados;
    private $DadosId;

    public function editDefeitos($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editDefeitosPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Defeito não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'defeitos/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editDefeitosPriv() {
        if (!empty($this->Dados['EditDefeitos'])) {
            unset($this->Dados['EditDefeitos']);
            $editarDefeitos = new \App\adms\Models\AdmsEditarDefeitos();
            $editarDefeitos->altDefeitos($this->Dados);
            if ($editarDefeitos->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Cadastro</strong> atualizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $UrlDestino = URLADM . 'ver-defeitos/ver-defeitos/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editDefeitosViewPriv();
            }
        } else {
            $verDash = new \App\adms\Models\AdmsEditarDefeitos();
            $this->Dados['form'] = $verDash->verDefeitos($this->DadosId);
            $this->editDefeitosViewPriv();
        }
    }

    private function editDefeitosViewPriv() {
        if ($this->Dados['form']) {
            $listarSelect = new \App\adms\Models\AdmsEditarDefeitos();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['vis_defeitos' => ['menu_controller' => 'ver-defeitos', 'menu_metodo' => 'ver-defeitos']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/defeitos/editarDefeitos", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Defeito não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'defeitos/listar';
            header("Location: $UrlDestino");
        }
    }

}
