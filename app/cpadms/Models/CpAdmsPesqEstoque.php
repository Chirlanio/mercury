<?php

namespace App\cpadms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of CpAdmsPesqEstoque
 *
 * @copyright (c) year, Chiralnio Silva - Grupo Meia Sola
 */
class CpAdmsPesqEstoque {

    private $Dados;
    private $Resultado;
    private $PageId;
    private $LimiteResultado = 50;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function pesqEstoque($PageId = null, $Dados = null) {

        $this->PageId = (int) $PageId;
        $this->Dados = $Dados;

        $this->Dados['referencia'] = trim($this->Dados['referencia']);

        $_SESSION['pesqLoja'] = $this->Dados['loja_id'];
        $_SESSION['pesqRef'] = $this->Dados['referencia'];

        if (!empty($this->Dados['loja_id'])) {
            $this->pesqLoja();
        } elseif (!empty($this->Dados['referencia'])) {
            $this->pesqReferencia();
        } elseif (!empty($this->Dados['refauxiliar'])) {
            $this->pesqCodBarras();
        }
        return $this->Resultado;
    }

    private function pesqLoja() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacaoCigam(URLADM . 'pesq-estoque/listar', '?loja_id=' . $this->Dados['loja_id']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(cod_barra) AS num_result FROM msl_festoqueatual_ 
                                WHERE loja =:loja AND saldo >:saldo", "loja={$this->Dados['loja_id']}&saldo=0");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarLojas = new \App\adms\Models\helper\AdmsReadCigam();
        $listarLojas->fullRead("SELECT e.loja loja_id, e.cod_barra, e.refauxiliar, e.saldo, p.referencia, p.tamanho tam, l.nome nome_loja
                                FROM msl_festoqueatual_ e
                                INNER JOIN msl_dprodutos_ p ON p.codbarra=e.cod_barra
                                INNER JOIN msl_dlojas_ l ON l.loja=e.loja
                                WHERE e.loja =:loja AND e.saldo >:saldo
                                ORDER BY e.loja, p.referencia, p.tamanho ASC LIMIT :limit OFFSET :offset", "loja={$this->Dados['loja_id']}&saldo=0&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarLojas->getResultado();
    }

    private function pesqReferencia() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacaoCigam(URLADM . 'pesq-estoque/listar', '?referencia=' . $this->Dados['referencia']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(e.cod_barra) AS num_result FROM msl_festoqueatual_ e
                                INNER JOIN msl_dprodutos_ p ON p.codbarra=e.cod_barra
                                WHERE p.referencia =:referencia AND e.saldo >:saldo", "referencia={$this->Dados['referencia']}&saldo=0");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarReferencia = new \App\adms\Models\helper\AdmsReadCigam();
        $listarReferencia->fullRead("SELECT e.loja loja_id, e.cod_barra, e.refauxiliar, e.saldo, p.referencia, p.tamanho tam, l.nome nome_loja
                                    FROM msl_festoqueatual_ e
                                    INNER JOIN msl_dprodutos_ p ON p.codbarra=e.cod_barra
                                    INNER JOIN msl_dlojas_ l ON l.loja=e.loja
                                    WHERE p.referencia =:referencia AND e.saldo >:saldo
                                    ORDER BY e.loja, p.referencia, p.tamanho ASC LIMIT :limit OFFSET :offset", "referencia={$this->Dados['referencia']}&saldo=0&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarReferencia->getResultado();
    }

    private function pesqCodBarras() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacaoCigam(URLADM . 'pesq-estoque/listar', '?refauxiliar=' . $this->Dados['refauxiliar']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(e.cod_barra) AS num_result FROM msl_festoqueatual_ e
                                INNER JOIN msl_dprodutos_ p ON p.codbarra=e.cod_barra
                                WHERE e.refauxiliar =:refauxiliar AND e.saldo >:saldo", "refauxiliar={$this->Dados['refauxiliar']}&saldo=0");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarProdutos = new \App\adms\Models\helper\AdmsReadCigam();
        $listarProdutos->fullRead("SELECT e.loja loja_id, e.cod_barra, e.refauxiliar, e.saldo, p.referencia, p.tamanho tam, l.nome nome_loja
                                    FROM msl_festoqueatual_ e
                                    INNER JOIN msl_dprodutos_ p ON p.codbarra=e.cod_barra
                                    INNER JOIN msl_dlojas_ l ON l.loja=e.loja
                                    WHERE p.refauxiliar =:refauxiliar AND e.saldo >:saldo
                                    ORDER BY e.loja, p.referencia, p.tamanho ASC LIMIT :limit OFFSET :offset", "refauxiliar={$this->Dados['refauxiliar']}&saldo=0&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarProdutos->getResultado();
    }

    public function listarCadastrar() {

        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas ORDER BY id ASC");
        $registro['loja_id'] = $listar->getResultado();

        $this->Resultado = ['loja_id' => $registro['loja_id']];

        return $this->Resultado;
    }

}
