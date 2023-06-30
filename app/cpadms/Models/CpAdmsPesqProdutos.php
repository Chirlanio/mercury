<?php

namespace App\cpadms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of CpAdmsPesqProdutos
 *
 * @copyright (c) year, Chiralnio Silva - Grupo Meia Sola
 */
class CpAdmsPesqProdutos {

    private $Dados;
    private $Resultado;
    private $PageId;
    private $LimiteResultado = 1;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function pesqProdutos($PageId = null, $Dados = null) {

        $this->PageId = (int) $PageId;
        $this->Dados = $Dados;

        $this->Dados['referencia'] = trim($this->Dados['referencia']);

        if ((!empty($this->Dados['referencia'])) AND (!empty($this->Dados['refauxiliar']))) {
            $this->pesqComp();
        } elseif (!empty($this->Dados['referencia'])) {
            $this->pesqRef();
        } elseif (!empty($this->Dados['refauxiliar'])) {
            $this->pesqCodBarras();
        }
        return $this->Resultado;
    }

    private function pesqComp() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacaoCigam(URLADM . 'produtos/pesq-produtos');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(DISTINCT referencia) AS num_result FROM msl_dprodutos_
                WHERE referencia =:referencia AND refauxiliar =:refauxiliar", "referencia={$this->Dados['referencia']}&refauxiliar={$this->Dados['refauxiliar']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarProdutos = new \App\adms\Models\helper\AdmsReadCigam();
        $listarProdutos->fullRead("SELECT referencia, refauxiliar, descricao, colecao, subcolecao, linha, marca
           FROM msl_dprodutos_
           WHERE referencia =:referencia AND refauxiliar =:refauxiliar
           GROUP BY referencia, refauxiliar, descricao, colecao, subcolecao, linha, marca
           ORDER BY referencia ASC LIMIT :limit OFFSET :offset", "referencia={$this->Dados['referencia']}&refauxiliar={$this->Dados['refauxiliar']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarProdutos->getResultado();
    }

    private function pesqRef() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacaoCigam(URLADM . 'produtos/pesq-produtos');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(DISTINCT referencia) AS num_result FROM msl_dprodutos_
                WHERE referencia =:referencia", "referencia={$this->Dados['referencia']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarProdutos = new \App\adms\Models\helper\AdmsReadCigam();
        $listarProdutos->fullRead("SELECT referencia, refauxiliar, descricao, colecao, subcolecao, linha, marca
           FROM msl_dprodutos_
           WHERE referencia =:referencia
           GROUP BY referencia, refauxiliar, descricao, colecao, subcolecao, linha, marca
           ORDER BY referencia ASC LIMIT :limit OFFSET :offset", "referencia={$this->Dados['referencia']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarProdutos->getResultado();
    }

    private function pesqCodBarras() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacaoCigam(URLADM . 'produtos/pesq-produtos');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(DISTINCT referencia) AS num_result FROM msl_dprodutos_
                WHERE refauxiliar =:refauxiliar", "refauxiliar={$this->Dados['refauxiliar']}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarProdutos = new \App\adms\Models\helper\AdmsReadCigam();
        $listarProdutos->fullRead("SELECT referencia, refauxiliar, descricao, colecao, subcolecao, linha, marca
           FROM msl_dprodutos_
           WHERE refauxiliar =:refauxiliar
           GROUP BY referencia, refauxiliar, descricao, colecao, subcolecao, linha, marca
           ORDER BY referencia ASC LIMIT :limit OFFSET :offset", "refauxiliar={$this->Dados['refauxiliar']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarProdutos->getResultado();
    }

}
