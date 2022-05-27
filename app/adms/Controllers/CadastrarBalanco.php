<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarBalanco
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CadastrarBalanco {

    private $Dados;

    public function cadBalanco() {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadBalanco'])) {
            unset($this->Dados['CadBalanco']);
            $cadBalanco = new \App\adms\Models\AdmsCadastrarBalanco();
            $cadBalanco->cadBalanco($this->Dados);
            if ($cadBalanco->getResultado()) {
                $UrlDestino = URLADM . 'balanco/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadBalancoViewPriv();
            }
        } else {
            $this->cadBalancoViewPriv();
        }
    }

    private function cadBalancoViewPriv() {
        $listarSelect = new \App\adms\Models\AdmsCadastrarBalanco();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $botao = ['list_balanco' => ['menu_controller' => 'balanco', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("adms/Views/auditoria/cadBalanco", $this->Dados);
        $carregarView->renderizar();
    }

}
