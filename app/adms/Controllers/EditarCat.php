<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarCat
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarCat {

    private $Dados;
    private $DadosId;

    public function editCat($DadosId = null) {

        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $this->DadosId = (int) $DadosId;

        if (!empty($this->DadosId)) {
            $this->editCatPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Categoria de artigo não encontrado!</div>";
            $UrlDestino = URLADM . 'categoria-artigo/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editCatPriv() {
        
        if (!empty($this->Dados['EditCat'])) {
            unset($this->Dados['EditCat']);
            $editarCat = new \App\adms\Models\AdmsEditarCat();
            $editarCat->altCat($this->Dados);
            if ($editarCat->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success'>Categoria de artigo editada com sucesso!</div>";
                $UrlDestino = URLADM . 'categoria-artigo/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editCatViewPriv();
            }
        } else {
            $verCat = new \App\adms\Models\AdmsEditarCat();
            $this->Dados['form'] = $verCat->verCat($this->DadosId);
            $this->editCatViewPriv();
        }
    }

    private function editCatViewPriv() {
        if ($this->Dados['form']) {
            
            $listarSelect = new \App\adms\Models\AdmsEditarArtigo();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['list_cat' => ['menu_controller' => 'categoria-artigo', 'menu_metodo' => 'listar']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/catArt/editarCat", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Categoria de artigo não encontrada!</div>";
            $UrlDestino = URLADM . 'categoria-artigo/listar';
            header("Location: $UrlDestino");
        }
    }

}
