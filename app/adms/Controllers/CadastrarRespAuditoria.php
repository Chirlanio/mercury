<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CadastrarRespAuditoria
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CadastrarRespAuditoria {

    private $Dados;

    public function cadRespAuditoria() {
        
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($this->Dados['CadRespAuditoria'])) {
            unset($this->Dados['CadRespAuditoria']);
            $cadRespAuditoria = new \App\adms\Models\AdmsCadastrarRespAuditoria();
            $cadRespAuditoria->cadRespAuditoria($this->Dados);
            if ($cadRespAuditoria->getResultado()) {
                $UrlDestino = URLADM . 'responsavel-auditoria/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadRespAuditoriaViewPriv();
            }
        } else {
            $this->cadRespAuditoriaViewPriv();
        }
    }

    private function cadRespAuditoriaViewPriv() {
        
        $botao = ['list_resp_auditoria' => ['menu_controller' => 'responsavel-auditoria', 'menu_metodo' => 'listar']];
        
        $listarBotao = new \App\adms\Models\AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        
        $listarSelect = new \App\adms\Models\AdmsCadastrarRespAuditoria();
        $this->Dados['select']=$listarSelect->listarCadastrar();
        
        $carregarView = new \Core\ConfigView("adms/Views/responsavelAuditoria/cadRespAuditoria", $this->Dados);
        $carregarView->renderizar();
    }

}
