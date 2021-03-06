<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarSitBalanco
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CadastrarSitBalanco {

    private $Dados;

    public function cadSit() {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadSit'])) {
            unset($this->Dados['CadSit']);
            $cadSit = new \App\adms\Models\AdmsCadastrarSitBalanco();
            $cadSit->cadSit($this->Dados);
            if ($cadSit->getResultado()) {
                $UrlDestino = URLADM . 'situacao-balanco/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadSitBalancoViewPriv();
            }
        } else {
            $this->cadSitBalancoViewPriv();
        }
    }

    private function cadSitBalancoViewPriv() {

        $botao = ['list_sit' => ['menu_controller' => 'situacao-balanco', 'menu_metodo' => 'listar']];
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        $carregarView = new \Core\ConfigView("adms/Views/situacaoBalanco/cadSitBalanco", $this->Dados);
        $carregarView->renderizar();
    }

}
