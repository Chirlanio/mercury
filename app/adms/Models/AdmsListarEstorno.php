<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarEstorno
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarEstorno {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listar($PageId = null) {

        $this->PageId = (int) $PageId;

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'estorno/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_estornos");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarArtigo = new \App\adms\Models\helper\AdmsRead();
        $listarArtigo->fullRead("SELECT a.*, lj.nome loja, est.nome tipo
                FROM adms_estornos a
                INNER JOIN tb_lojas lj ON lj.id=a.loja_id
                INNER JOIN adms_sits_estornos est ON est.id=a.adms_sits_est_id
                ORDER BY id DESC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarArtigo->getResultado();
        return $this->Resultado;
    }

}
