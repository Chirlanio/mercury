<?php

namespace App\adms\Controllers;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of ApagarRespAuditoria
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class ApagarRespAuditoria {

    private $DadosId;

    public function apagarRespAuditoria($DadosId = null) {

        $this->DadosId = (int) $DadosId;

        if (!empty($this->DadosId)) {
            $apagarRespAuditoria = new \App\adms\Models\AdmsApagarRespAuditoria();
            $apagarRespAuditoria->apagarRespAuditoria($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Selecione um registro!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
        $UrlDestino = URLADM . 'responsavel-auditoria/listar';
        header("Location: $UrlDestino");
    }

}
