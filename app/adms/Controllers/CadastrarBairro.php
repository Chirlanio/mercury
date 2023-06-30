<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarBairro
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CadastrarBairro {

    private $Dados;

    public function cadBairro() {
        
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($this->Dados['CadBairro'])) {
            unset($this->Dados['CadBairro']);
            $cadBairro = new \App\adms\Models\AdmsCadastrarBairro();
            $cadBairro->cadBairro($this->Dados);
            if ($cadBairro->getResultado()) {
                $UrlDestino = URLADM . 'bairro/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadBairroViewPriv();
            }
        } else {
            $this->cadBairroViewPriv();
        }
    }

    private function cadBairroViewPriv() {
        
        $botao = ['list_bairro' => ['menu_controller' => 'bairro', 'menu_metodo' => 'listar']];
        
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        
        $listarSelect = new \App\adms\Models\AdmsCadastrarBairro();
        $this->Dados['select']=$listarSelect->listarCadastrar();
        
        $carregarView = new \Core\ConfigView("adms/Views/bairro/cadBairro", $this->Dados);
        $carregarView->renderizar();
    }

}
