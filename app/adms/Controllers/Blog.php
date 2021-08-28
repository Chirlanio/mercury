<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of Blog
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class Blog {

    private $Dados;
    private $PageId;

    public function listar($PageId = null) {

        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_artigo' => ['menu_controller' => 'cadastrar-artigo', 'menu_metodo' => 'cad-artigo'],
            'vis_artigo' => ['menu_controller' => 'ver-artigo', 'menu_metodo' => 'ver-artigo'],
            'edit_artigo' => ['menu_controller' => 'editar-artigo', 'menu_metodo' => 'edit-artigo'],
            'del_artigo' => ['menu_controller' => 'apagar-artigo', 'menu_metodo' => 'apagar-artigo']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarArtigo = new \App\adms\Models\AdmsListarBlog();
        $this->Dados['listArtigo'] = $listarArtigo->listar($this->PageId);
        $this->Dados['paginacao'] = $listarArtigo->getResultadoPg();

        $listarArtRecente = new \App\adms\Models\AdmsListarBlog();
        $this->Dados['artRecente'] = $listarArtRecente->listarArtRecente();
        
        $listarArtDestaque = new \App\adms\Models\AdmsListarBlog();
        $this->Dados['artDestaque'] = $listarArtDestaque->listarArtDestaque();

        $carregarView = new \Core\ConfigView("adms/Views/artigo/blog", $this->Dados);
        $carregarView->renderizar();
    }

}
