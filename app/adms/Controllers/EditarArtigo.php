<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarArtigo
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meia Sola
 */
class EditarArtigo {

    private $Dados;
    private $DadosId;

    public function editArtigo($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editArtigoPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Artigo não encontrado!</div>";
            $UrlDestino = URLADM . 'artigo/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editArtigoPriv() {
        if (!empty($this->Dados['EditArtigo'])) {
            unset($this->Dados['EditArtigo']);
            $this->Dados['imagem_nova'] = ($_FILES['imagem_nova'] ? $_FILES['imagem_nova'] : null);
            $editarArtigo = new \App\adms\Models\AdmsEditarArtigo();
            $editarArtigo->altArtigo($this->Dados);
            
            if ($editarArtigo->getResultado()) {
                $UrlDestino = URLADM . 'ver-artigo/ver-artigo/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editArtigoViewPriv();
            }
        } else {
            $verArtigo = new \App\adms\Models\AdmsEditarArtigo();
            $this->Dados['form'] = $verArtigo->verArtigo($this->DadosId);
            $this->editArtigoViewPriv();
        }
    }

    private function editArtigoViewPriv() {
        if ($this->Dados['form']) {
            
            $listarSelect = new \App\adms\Models\AdmsEditarArtigo();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['vis_art' => ['menu_controller' => 'ver-artigo', 'menu_metodo' => 'ver-artigo'],
                'list_art' => ['menu_controller' => 'artigo', 'menu_metodo' => 'listar']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/artigo/editarArtigo", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Artigo não encontrado!</div>";
            $UrlDestino = URLADM . 'artigo/listar';
            header("Location: $UrlDestino");
        }
    }

}
