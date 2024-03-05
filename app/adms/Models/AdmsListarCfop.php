<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarCfop
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarCfop {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 25;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listar($PageId = null) {

        $this->PageId = (int) $PageId;

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'cfop/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_cfops");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarCfop = new \App\adms\Models\helper\AdmsRead();
        $listarCfop->fullRead("SELECT * FROM adms_cfops ORDER BY id ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarCfop->getResult();
        return $this->Resultado;
    }

}
