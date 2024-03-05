<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarMotivo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarMotivo {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = LIMIT;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listarMotivo($PageId = null) {
        
        $this->PageId = (int) $PageId;
        
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'motivo-estorno/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_motivo_estorno");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarCargo = new \App\adms\Models\helper\AdmsRead();
        $listarCargo->fullRead("SELECT b.id, b.nome motivo FROM adms_motivo_estorno b ORDER BY b.id ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarCargo->getResult();
        return $this->Resultado;
    }

}
