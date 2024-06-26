<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarSitDelivery
 *
 * @copyright (c) Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarSitDelivery {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = LIMIT;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listarSit($PageId = null) {
        $this->PageId = (int) $PageId;
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'situacao-delivery/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_status_delivery");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarSit = new \App\adms\Models\helper\AdmsRead();
        $listarSit->fullRead("SELECT sit.*, cr.cor cor_cr FROM tb_status_delivery sit INNER JOIN adms_cors cr ON cr.id=sit.adms_cor_id ORDER BY sit.id ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarSit->getResult();
        return $this->Resultado;
    }

}
