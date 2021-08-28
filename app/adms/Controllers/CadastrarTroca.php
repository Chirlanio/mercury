<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarTroca
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CadastrarTroca {

    private $Dados;

    public function cadTroca() {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadTroca'])) {
            unset($this->Dados['CadTroca']);
            $cadTroca = new \App\adms\Models\AdmsCadastrarTroca();
            $cadTroca->cadTroca($this->Dados);
            if ($cadTroca->getResultado()) {
                $UrlDestino = URLADM . 'listar-troca/listar-troca';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadTrocaViewPriv();
            }
        } else {
            $this->cadTrocaViewPriv();
        }
    }

    private function cadTrocaViewPriv() {
        $listarSelect = new \App\adms\Models\AdmsCadastrarTroca();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $botao = ['list_troca' => ['menu_controller' => 'cadastrar-troca', 'menu_metodo' => 'cad-troca']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("adms/Views/troca/cadTroca", $this->Dados);
        $carregarView->renderizar();
    }

}
