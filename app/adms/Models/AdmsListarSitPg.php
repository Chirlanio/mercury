<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarSitPg
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarSitPg {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = LIMIT;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listarSitPg($PageId = null) {
        $this->PageId = (int) $PageId;
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'situacao-pg/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_sits_pgs");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarSitPg = new \App\adms\Models\helper\AdmsRead();
        $listarSitPg->fullRead("SELECT * FROM adms_sits_pgs sit ORDER BY nome ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarSitPg->getResult();
        return $this->Resultado;
    }

}
