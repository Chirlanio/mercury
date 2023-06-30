<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarSit
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CadastrarSitTransf {

    private $Dados;

    public function cadSit() {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadSit'])) {
            unset($this->Dados['CadSit']);
            $cadSit = new \App\adms\Models\AdmsCadastrarSitTransf();
            $cadSit->cadSit($this->Dados);
            if ($cadSit->getResultado()) {
                $UrlDestino = URLADM . 'situacao-transf/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadSitViewPriv();
            }
        } else {
            $this->cadSitViewPriv();
        }
    }

    private function cadSitViewPriv() {
        $listarSelect = new \App\adms\Models\AdmsCadastrarSitTransf();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $botao = ['list_sit' => ['menu_controller' => 'situacao-transf', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("adms/Views/situacaoTransf/cadSit", $this->Dados);
        $carregarView->renderizar();
    }

}
