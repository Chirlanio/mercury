<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarMotivo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CadastrarMotivo {

    private $Dados;

    public function cadMotivo() {
        
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($this->Dados['CadMotivo'])) {
            unset($this->Dados['CadMotivo']);
            $cadMotivo = new \App\adms\Models\AdmsCadastrarMotivo();
            $cadMotivo->cadMotivo($this->Dados);
            if ($cadMotivo->getResultado()) {
                $UrlDestino = URLADM . 'motivo-estorno/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadMotivoViewPriv();
            }
        } else {
            $this->cadMotivoViewPriv();
        }
    }

    private function cadMotivoViewPriv() {
        
        $botao = ['list_motivo' => ['menu_controller' => 'motivo-estorno', 'menu_metodo' => 'listar']];
        
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        
        $carregarView = new \Core\ConfigView("adms/Views/motivo/cadMotivo", $this->Dados);
        $carregarView->renderizar();
    }

}
