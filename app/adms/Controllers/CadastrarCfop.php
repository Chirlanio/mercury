<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarCfop
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CadastrarCfop {

    private $Dados;

    public function cadCfop() {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadCfop'])) {
            unset($this->Dados['CadCfop']);
            $cadCfop = new \App\adms\Models\AdmsCadastrarCfop();
            $cadCfop->cadCfop($this->Dados);
            if ($cadCfop->getResultado()) {
                $UrlDestino = URLADM . 'cfop/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadCfopViewPriv();
            }
        } else {
            $this->cadCfopViewPriv();
        }
    }

    private function cadCfopViewPriv() {
        $botao = ['list_cfop' => ['menu_controller' => 'cfop', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("adms/Views/faq/cadCfop", $this->Dados);
        $carregarView->renderizar();
    }

}
