<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarResp
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarResp {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listarResp($PageId = null) {
        $this->PageId = (int) $PageId;
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'autorizacao-resp/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(resp.id) AS num_result FROM adms_resp_autorizacao resp");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarNivAc = new \App\adms\Models\helper\AdmsRead();
        $listarNivAc->fullRead("SELECT resp.id, resp.nome
                FROM adms_resp_autorizacao resp
                ORDER BY resp.nome ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarNivAc->getResultado();
        return $this->Resultado;
    }

}
