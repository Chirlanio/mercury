<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarCat
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CadastrarCat {

    private $Dados;

    public function cadCat() {

        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->Dados['CadCat'])) {
            unset($this->Dados['CadCat']);
            $cadCat = new \App\adms\Models\AdmsCadastrarCat();
            $cadCat->cadCat($this->Dados);
            if ($cadCat->getResultado()) {
                $UrlDestino = URLADM . 'categoria-artigo/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadCatViewPriv();
            }
        } else {
            $this->cadCatViewPriv();
        }
    }

    private function cadCatViewPriv() {

        $botao = ['list_cat' => ['menu_controller' => 'categoria-artigo', 'menu_metodo' => 'listar']];

        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $carregarView = new \Core\ConfigView("adms/Views/catArt/cadCat", $this->Dados);
        $carregarView->renderizar();
    }

}
