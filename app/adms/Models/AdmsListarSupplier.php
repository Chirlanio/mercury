<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarSupplier
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarSupplier {

    private $Resultado;
    private $PageId;
    private $Limit = LIMIT;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listSupplier($PageId = null) {
        
        $this->PageId = (int) $PageId;
        
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'supplier/list');
        $paginacao->condicao($this->PageId, $this->Limit);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_suppliers");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarSupplier = new \App\adms\Models\helper\AdmsRead();
        $listarSupplier->fullRead("SELECT s.id id_supp, s.corporate_social, s.fantasy_name, st.nome status FROM adms_suppliers s INNER JOIN adms_sits st ON st.id=s.status_id ORDER BY s.id ASC LIMIT :limit OFFSET :offset", "limit={$this->Limit}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarSupplier->getResult();
        return $this->Resultado;
    }

}
