<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarProdutos
 *
 * @copyright (c) year, Chiralnio Silva - Grupo Meia Sola
 */
class AdmsListarProdutos {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 50;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listarProdutos($PageId = null) {
        
        $this->PageId = (int) $PageId;
        
        $paginacao = new \App\adms\Models\helper\AdmsPaginacaoCigam(URLADM . 'produtos/listar-produtos');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(DISTINCT referencia) AS num_result FROM msl_dprodutos_");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarProdutos = new \App\adms\Models\helper\AdmsReadCigam();
        $listarProdutos->fullRead("SELECT referencia, refauxiliar, descricao, colecao, marca
           FROM msl_dprodutos_
           GROUP BY referencia, refauxiliar, descricao, colecao, marca
           LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarProdutos->getResultado();
        return $this->Resultado;
    }

}
