<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarLoja
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CadastrarLoja {

    private $Dados;

    public function cadLoja() {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadLoja'])) {
            unset($this->Dados['CadLoja']);
            $cadLoja = new \App\adms\Models\AdmsCadastrarLoja();
            $cadLoja->cadLoja($this->Dados);
            if ($cadLoja->getResultado()) {
                $UrlDestino = URLADM . 'lojas/listarLojas';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadLojaViewPriv();
            }
        } else {
            $this->cadLojaViewPriv();
        }
    }

    private function cadLojaViewPriv() {
        $listarSelect = new \App\adms\Models\AdmsCadastrarLoja();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $botao = ['list_loja' => ['menu_controller' => 'loja', 'menu_metodo' => 'listar-lojas']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("adms/Views/loja/cadLoja", $this->Dados);
        $carregarView->renderizar();
    }

}
