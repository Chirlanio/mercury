<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListBanks
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListBanks {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResultado() {
        return $this->ResultadoPg;
    }

    public function listBanks($PageId = null) {
        
        $this->PageId = (int) $PageId;
        
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'banks/list');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_banks");
        $this->ResultadoPg = $paginacao->getResultado();

        $listBank = new \App\adms\Models\helper\AdmsRead();
        $listBank->fullRead("SELECT b.id, b.bank_name, b.cod_bank, st.nome status
                FROM adms_banks b
                LEFT JOIN adms_sits st ON st.id = b.status_id
                ORDER BY b.id ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listBank->getResultado();
        return $this->Resultado;
    }

}
