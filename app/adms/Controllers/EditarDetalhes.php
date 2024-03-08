<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarDetalhes
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarDetalhes {

    private $Dados;
    private $DadosId;

    public function editDetalhes($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editDetalhesPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Detalhe não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'detalhes/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editDetalhesPriv() {
        if (!empty($this->Dados['EditDetalhes'])) {
            unset($this->Dados['EditDetalhes']);
            $editarDetalhes = new \App\adms\Models\AdmsEditarDetalhes();
            $editarDetalhes->altDetalhes($this->Dados);
            if ($editarDetalhes->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Cadastro</strong> atualizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $UrlDestino = URLADM . 'ver-detalhes/ver-detalhes/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editDetalhesViewPriv();
            }
        } else {
            $verDetalhes = new \App\adms\Models\AdmsEditarDetalhes();
            $this->Dados['form'] = $verDetalhes->verDetalhes($this->DadosId);
            $this->editDetalhesViewPriv();
        }
    }

    private function editDetalhesViewPriv() {
        if ($this->Dados['form']) {
            $listarSelect = new \App\adms\Models\AdmsEditarDetalhes();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['list_detalhes' => ['menu_controller' => 'detalhes', 'menu_metodo' => 'listar'], 'vis_detalhes' => ['menu_controller' => 'ver-detalhes', 'menu_metodo' => 'ver-detalhes']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/detalhes/editarDetalhes", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Detalhe não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'detalhes/listar';
            header("Location: $UrlDestino");
        }
    }
}
