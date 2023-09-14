<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListTypePayment
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListTypePayment {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listTypes($PageId = null) {
        
        $this->PageId = (int) $PageId;
        
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'type-payments/list');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_type_payments");
        $this->ResultadoPg = $paginacao->getResultado();

        $listTypes = new \App\adms\Models\helper\AdmsRead();
        $listTypes->fullRead("SELECT tp.id, tp.name, s.nome status
                FROM adms_type_payments tp
                LEFT JOIN adms_sits s ON s.id=tp.status_id
                ORDER BY tp.id ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listTypes->getResultado();
        return $this->Resultado;
    }

}
