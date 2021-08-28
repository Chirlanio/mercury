<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of class CadastrarPed

 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CadastrarPed {

    private $Dados;

    public function cadPed() {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadPed'])) {
            unset($this->Dados['CadPed']);
            $cadPed = new \App\adms\Models\AdmsCadastrarPed();
            $cadPed->cadPed($this->Dados);
            if ($cadPed->getResultado()) {
                $UrlDestino = URLADM . 'prateleira-infinita/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadPedViewPriv();
            }
        } else {
            $this->cadPedViewPriv();
        }
    }

    private function cadPedViewPriv() {
        $listarSelect = new \App\adms\Models\AdmsCadastrarPed();
        $this->Dados['select'] = $listarSelect->listarCadastrar();

        $botao = ['list_ped' => ['menu_controller' => 'prateleira-infinita', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("adms/Views/prateleira/cadPed", $this->Dados);
        $carregarView->renderizar();
    }

}
