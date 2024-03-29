<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarSitAjuste
 *
 * @copyright (c) Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarSitAjuste {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = LIMIT;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listarSitAjuste($PageId = null) {
        $this->PageId = (int) $PageId;
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'situacao-ajuste/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM tb_status_aj");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarSit = new \App\adms\Models\helper\AdmsRead();
        $listarSit->fullRead("SELECT sit.*, cr.cor cor_cr FROM tb_status_aj sit INNER JOIN adms_cors cr ON cr.id=sit.adms_cor_id ORDER BY sit.nome ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarSit->getResult();
        return $this->Resultado;
    }

}
