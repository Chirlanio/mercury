<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarTipo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CadastrarTipo {

    private $Dados;

    public function cadTipo() {

        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->Dados['CadTipo'])) {
            unset($this->Dados['CadTipo']);
            $cadTipo = new \App\adms\Models\AdmsCadastrarTipo();
            $cadTipo->cadTipo($this->Dados);
            if ($cadTipo->getResultado()) {
                $UrlDestino = URLADM . 'tipo-artigo/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadTipoViewPriv();
            }
        } else {
            $this->cadTipoViewPriv();
        }
    }

    private function cadTipoViewPriv() {

        $botao = ['list_tipo' => ['menu_controller' => 'tipo-artigo', 'menu_metodo' => 'listar']];

        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $carregarView = new \Core\ConfigView("adms/Views/tipoArt/cadTipo", $this->Dados);
        $carregarView->renderizar();
    }

}
