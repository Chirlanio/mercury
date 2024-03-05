<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarEstoque
 *
 * @copyright (c) year, Chiralnio Silva - Grupo Meia Sola
 */
class AdmsListarEstoque {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 50;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listar($PageId = null) {

        $this->PageId = (int) $PageId;

        $paginacao = new \App\adms\Models\helper\AdmsPaginacaoCigam(URLADM . 'estoque/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(cod_barra) AS num_result FROM msl_festoqueatual_ WHERE saldo > 0");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarEstoque = new \App\adms\Models\helper\AdmsReadCigam();
        $listarEstoque->fullRead("SELECT e.loja, e.cod_barra, e.refauxiliar, e.saldo, p.referencia, p.tamanho tam
            FROM msl_festoqueatual_ e
            INNER JOIN msl_dprodutos_ p ON p.codbarra=e.cod_barra
            WHERE e.saldo > 0
            ORDER BY e.loja, p.referencia, p.tamanho ASC
            LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarEstoque->getResult();
        return $this->Resultado;
    }

    public function listarCadastrar() {

        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas ORDER BY id ASC");
        $registro['loja_id'] = $listar->getResult();

        $this->Resultado = ['loja_id' => $registro['loja_id']];

        return $this->Resultado;
    }

}
