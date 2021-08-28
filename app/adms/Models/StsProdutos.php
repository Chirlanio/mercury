<?php

namespace Sts\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of StsProdutos
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class StsProdutos {

    private $Resultado;
    private $PageId;
    private $ResultadoPg;
    private $LimiteResultado = 50;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listarProdutos($PageId = null) {

        $this->PageId = (int) $PageId;
        $paginacao = new \Sts\Models\helper\StsPaginacao(URL . 'produtos');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao('SELECT COUNT(referencia) AS num_result
                FROM msl_dprodutos_');
        $this->ResultadoPg = $paginacao->getResultado();

        $listarProd = new \Sts\Models\helper\StsReadCigam();
        //$listarProd->exeRead('msl_dlojas_','limit=10');
        $listarProd->fullRead('SELECT p.referencia, p.refauxiliar, p.colecao, p.subcolecao, p.linha, p.tamanho, p.artigo, p.complartigo, p.cor,
           p.marca, p.material, p.datacadastro, p.min_vlrvenda
           FROM msl_dprodutos_ p
           LIMIT :limit OFFSET :offset', "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarProd->getResultado();
        return $this->Resultado;
    }

}
