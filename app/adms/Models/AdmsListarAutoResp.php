<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarAutoResp
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarAutoResp {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;
    private $Resp;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listar($PageId = null, $Resp = null) {
        $this->PageId = (int) $PageId;
        $this->Resp = (int) $Resp;

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'financeiro/listar-autorizacoes', "?resp=" . $this->Resp);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(est.id) AS num_result 
                FROM adms_estornos est
                WHERE est.adms_resp_aut_id =:adms_resp_aut_id
                ", "adms_resp_aut_id={$this->Resp}");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarUsuario = new \App\adms\Models\helper\AdmsRead();
        $listarUsuario->fullRead("SELECT est.*, lj.nome loja
                FROM adms_estornos est
                INNER JOIN tb_lojas lj ON lj.id=est.loja_id
                WHERE est.adms_resp_aut_id =:adms_resp_aut_id AND est.adms_sits_est_id <=:adms_sits_est_id
                ORDER BY est.id ASC LIMIT :limit OFFSET :offset", "adms_resp_aut_id={$this->Resp}&adms_sits_est_id=5&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarUsuario->getResultado();
        return $this->Resultado;
    }

    public function verResp($DadosId) {
        $this->DadosId = (int) $DadosId;
        $verNivAc = new \App\adms\Models\helper\AdmsRead();
        $verNivAc->fullRead("SELECT id, nome FROM adms_resp_autorizacao 
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verNivAc->getResultado();
        return $this->Resultado;
    }

}
