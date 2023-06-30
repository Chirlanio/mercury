<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarRespAuditoria
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class EditarRespAuditoria {

    private $Dados;
    private $DadosId;

    public function editRespAuditoria($DadosId = null) {
        
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        $this->DadosId = (int) $DadosId;
        
        if (!empty($this->DadosId)) {
            $this->editRespAuditoriaPriv();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Erro:</strong> Registro não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'responsavel-auditoria/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editRespAuditoriaPriv() {
        if (!empty($this->Dados['EditRespAuditoria'])) {
            unset($this->Dados['EditRespAuditoria']);
            $editarRespAuditoria = new \App\adms\Models\AdmsEditarRespAuditoria();
            $editarRespAuditoria->altRespAuditoria($this->Dados);
            if ($editarRespAuditoria->getResultado()) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Cadastro</strong> atualizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $UrlDestino = URLADM . 'ver-resp-auditoria/ver-resp-auditoria/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editRespAuditoriaViewPriv();
            }
        } else {
            $verRespAuditoria = new \App\adms\Models\AdmsEditarRespAuditoria();
            $this->Dados['form'] = $verRespAuditoria->verRespAuditoria($this->DadosId);
            $this->editRespAuditoriaViewPriv();
        }
    }

    private function editRespAuditoriaViewPriv() {
        if ($this->Dados['form']) {
            
            $listarSelect = new \App\adms\Models\AdmsEditarRespAuditoria();
            $this->Dados['select'] = $listarSelect->listarCadastrar();
            
            $botao = ['vis_resp_auditoria' => ['menu_controller' => 'ver-resp-auditoria', 'menu_metodo' => 'ver-resp-auditoria']];
            $listarBotao = new \App\adms\Models\AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new \App\adms\Models\AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new \Core\ConfigView("adms/Views/responsavelAuditoria/editarRespAuditoria", $this->Dados);
            $carregarView->renderizar();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Erro:</strong> Registro não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $UrlDestino = URLADM . 'responsavel-auditoria/listar';
            header("Location: $UrlDestino");
        }
    }

}
