<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarCor
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CadastrarCargo {

    private $Dados;

    public function cadCargo() {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadCargo'])) {
            unset($this->Dados['CadCargo']);
            $cadCargo = new \App\adms\Models\AdmsCadastrarCargo();
            $cadCargo->cadCargo($this->Dados);
            if ($cadCargo->getResultado()) {
                $UrlDestino = URLADM . 'cargo/listarCargo';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadCargoViewPriv();
            }
        } else {
            $this->cadCargoViewPriv();
        }
    }

    private function cadCargoViewPriv() {
        $botao = ['list_cargo' => ['menu_controller' => 'cargo', 'menu_metodo' => 'listarCargo']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("adms/Views/cargo/cadCargo", $this->Dados);
        $carregarView->renderizar();
    }

}
