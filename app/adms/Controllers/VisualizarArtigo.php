<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of VisualizarArtigo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class VisualizarArtigo {

    private $Dados;
    private $Slug;

    public function index($Slug) {

        $this->Slug = (string) $Slug;

        if (!empty($this->Slug)) {

            $verArtigo = new \App\adms\Models\AdmsVisuArtigo();
            $this->Dados['visuArtigos'] = $verArtigo->verArtigo($this->Slug);

            $recentes = new \App\adms\Models\AdmsArtRecente();
            $this->Dados['artRecente'] = $recentes->listarArtRecente();

            $destaques = new \App\adms\Models\AdmsArtDestaque();
            $this->Dados['artDestaque'] = $destaques->listarArtDestaque();

            $botao = ['list_art' => ['menu_controller' => 'artigo', 'menu_metodo' => 'listar']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/artigo/artigo", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Artigo não encontrado!</div>";
            $UrlDestino = URLADM . 'blog/listar';
            header("Location: $UrlDestino");
        }
    }

}
