<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarSitBalanco
 *
 * @copyright (c) Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarSitBalanco {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listarSitBalanco($PageId = null) {
        $this->PageId = (int) $PageId;
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'situacao-balanco/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_status_balancos");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarSit = new \App\adms\Models\helper\AdmsRead();
        $listarSit->fullRead("SELECT sit.*
                FROM adms_status_balancos sit
                ORDER BY sit.id ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarSit->getResultado();
        return $this->Resultado;
    }

}
