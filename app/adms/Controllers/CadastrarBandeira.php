<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarBandeira
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CadastrarBandeira {

    private $Dados;

    public function cadBandeira() {
        
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($this->Dados['CadBandeira'])) {
            unset($this->Dados['CadBandeira']);
            $cadBandeira = new \App\adms\Models\AdmsCadastrarBandeira();
            $cadBandeira->cadBandeira($this->Dados);
            if ($cadBandeira->getResultado()) {
                $UrlDestino = URLADM . 'bandeira/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadBandeiraViewPriv();
            }
        } else {
            $this->cadBandeiraViewPriv();
        }
    }

    private function cadBandeiraViewPriv() {
        
        $botao = ['list_bandeira' => ['menu_controller' => 'bandeira', 'menu_metodo' => 'listar']];
        
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        
        $carregarView = new \Core\ConfigView("adms/Views/bandeira/cadBandeira", $this->Dados);
        $carregarView->renderizar();
    }

}
