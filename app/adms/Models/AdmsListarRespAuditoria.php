<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarRespAuditoria
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarRespAuditoria {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listarRespAuditoria($PageId = null) {
        
        $this->PageId = (int) $PageId;
        
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'responsavel-auditoria/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_responsavel_auditoria");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarCargo = new \App\adms\Models\helper\AdmsRead();
        $listarCargo->fullRead("SELECT r.id, r.nome resp, s.nome status
                FROM adms_responsavel_auditoria r
                INNER JOIN adms_sits s ON s.id=r.status_id
                ORDER BY r.id ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarCargo->getResultado();
        return $this->Resultado;
    }

}
