<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarArtigo
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meia Sola
 */
class CadastrarArtigo {

    private $Dados;

    public function cadArtigo() {

        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->Dados['CadArtigo'])) {
            unset($this->Dados['CadArtigo']);
            $this->Dados['imagem_nova'] = ($_FILES['imagem_nova'] ? $_FILES['imagem_nova'] : null);
            $cadArtigo = new \App\adms\Models\AdmsCadastrarArtigo();
            $cadArtigo->cadArtigo($this->Dados);
            //var_dump($this->Dados);
            if ($cadArtigo->getResultado()) {
                $UrlDestino = URLADM . 'artigo/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadArtigoViewPriv();
            }
        } else {
            $this->cadArtigoViewPriv();
        }
    }

    private function cadArtigoViewPriv() {

        $listarSelect = new \App\adms\Models\AdmsCadastrarArtigo();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $botao = ['list_art' => ['menu_controller' => 'artigo', 'menu_metodo' => 'listar'],
            'ver_art' => ['menu_controller' => 'ver-artigo', 'menu_metodo' => 'ver-artigo']];

        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $carregarView = new \Core\ConfigView("adms/Views/artigo/cadArtigo", $this->Dados);
        $carregarView->renderizar();
    }

}
