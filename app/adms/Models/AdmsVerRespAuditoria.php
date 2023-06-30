<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsVerRespAuditoria
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsVerRespAuditoria {

    private $Resultado;
    private $DadosId;

    public function verRespAuditoria($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verRespAuditoria = new \App\adms\Models\helper\AdmsRead();
        $verRespAuditoria->fullRead("SELECT r.id, r.nome resp, r.status_id, r.created, r.modified, s.nome status
                FROM adms_responsavel_auditoria r
                INNER JOIN adms_sits s ON s.id=r.status_id
                WHERE r.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verRespAuditoria->getResultado();
        return $this->Resultado;
    }

}
