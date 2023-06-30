<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarRota
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CadastrarRota {

    private $Dados;

    public function cadRota() {
        
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($this->Dados['CadRota'])) {
            unset($this->Dados['CadRota']);
            
            $cadRota = new \App\adms\Models\AdmsCadastrarRota();
            $cadRota->cadRota($this->Dados);
            if ($cadRota->getResultado()) {
                $UrlDestino = URLADM . 'rota/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadRotaViewPriv();
            }
        } else {
            $this->cadRotaViewPriv();
        }
    }

    private function cadRotaViewPriv() {
        
        $botao = ['list_rota' => ['menu_controller' => 'rota', 'menu_metodo' => 'listar']];
        
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        
        $listarSelect = new \App\adms\Models\AdmsCadastrarRota();
        $this->Dados['select']=$listarSelect->listarCadastrar();
        
        $carregarView = new \Core\ConfigView("adms/Views/rota/cadRota", $this->Dados);
        $carregarView->renderizar();
    }

}
