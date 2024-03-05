<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListBrands
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListBrands {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResultado() {
        return $this->ResultadoPg;
    }

    public function listBrand($PageId = null) {
        
        $this->PageId = (int) $PageId;
        
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'brands/list');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_brands_suppliers");
        $this->ResultadoPg = $paginacao->getResultado();

        $listBrand = new \App\adms\Models\helper\AdmsRead();
        $listBrand->fullRead("SELECT b.id, b.brand, s.fantasy_name supplier, st.nome status
                FROM adms_brands_suppliers b
                LEFT JOIN adms_suppliers s ON s.id = b.adms_supplier_id
                LEFT JOIN adms_sits st ON st.id = b.status_id
                ORDER BY b.id ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listBrand->getResult();
        return $this->Resultado;
    }

}
