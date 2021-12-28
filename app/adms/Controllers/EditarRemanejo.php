<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarRemanejo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarRemanejo {

    private $Dados;
    private $DadosId;

    public function editRemanejo($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editRemanejoPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Remanejo não encontrado!</div>";
            $UrlDestino = URLADM . 'remanejo/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editRemanejoPriv() {
        if (!empty($this->Dados['EditRemanejo'])) {
            unset($this->Dados['EditRemanejo']);
            $this->Dados['novo_file'] = ($_FILES['novo_file'] ? $_FILES['novo_file'] : null);
            $editarRemanejo = new \App\adms\Models\AdmsEditarRemanejo();
            $editarRemanejo->altRemanejo($this->Dados);
            if ($editarRemanejo->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Remanejo editado com sucesso!</div>";
                $UrlDestino = URLADM . 'remanejo/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editRemanejoViewPriv();
            }
        } else {
            $verRemanejo = new \App\adms\Models\AdmsEditarRemanejo();
            $this->Dados['form'] = $verRemanejo->verRemanejo($this->DadosId);
            $this->editRemanejoViewPriv();
        }
    }

    private function editRemanejoViewPriv() {
        if ($this->Dados['form']) {
            $listarSelect = new \App\adms\Models\AdmsEditarRemanejo();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['list_remanejo' => ['menu_controller' => 'remanejo', 'menu_metodo' => 'listar']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/remanejo/editarRemanejo", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Remanejo não encontrado!</div>";
            $UrlDestino = URLADM . 'remanejo/listar';
            header("Location: $UrlDestino");
        }
    }

}
