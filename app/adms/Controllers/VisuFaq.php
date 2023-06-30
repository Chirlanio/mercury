<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of VisuFaq
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class VisuFaq {

    private $Dados;
    private $Slug;

    public function index($Slug) {

        $this->Slug = (string) $Slug;

        if (!empty($this->Slug)) {

            $verArtigo = new \App\adms\Models\AdmsVisuFaq();
            $this->Dados['visuFaq'] = $verArtigo->verFaq($this->Slug);

            $botao = ['list_faq' => ['menu_controller' => 'faq', 'menu_metodo' => 'listar']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/faq/faq", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Artigo não encontrado!</div>";
            $UrlDestino = URLADM . 'faq/listar';
            header("Location: $UrlDestino");
        }
    }

}
