<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsSupplyCheckList
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsSupplyCheckList {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = LIMIT;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function list($PageId = null) {

        $this->PageId = (int) $PageId;

        unset($_SESSION['search']);

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'supply-check-list/list');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_supply_check_lists");
        $this->ResultadoPg = $paginacao->getResultado();

        $listCheckList = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION) {
            $listCheckList->fullRead("SELECT cl.id, cl.adms_store_id, cl.hash_id, cl.responsible_applicator, cl.adms_sit_check_list_id, lj.nome store_name, scl.name_sit, cr.cor cor_cr, f.nome applicator FROM adms_supply_check_lists cl LEFT JOIN tb_lojas lj ON lj.id = cl.adms_store_id LEFT JOIN adms_supply_sit_check_lists scl ON scl.id = cl.adms_sit_check_list_id LEFT JOIN adms_cors cr On cr.id = scl.adms_cor_id LEFT JOIN tb_funcionarios f ON f.id = cl.responsible_applicator AND f.loja_id = 'Z443' ORDER BY cl.id DESC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listCheckList->fullRead("SELECT cl.id, cl.adms_store_id, cl.hash_id, cl.responsible_applicator, cl.adms_sit_check_list_id, lj.nome store_name, scl.name_sit, cr.cor cor_cr FROM adms_supply_check_lists cl LEFT JOIN tb_lojas lj ON lj.id = cl.adms_store_id LEFT JOIN adms_supply_sit_check_lists scl ON scl.id = cl.adms_sit_check_list_id LEFT JOIN adms_cors cr On cr.id = scl.adms_cor_id LEFT JOIN tb_funcionarios f ON f.id = cl.responsible_applicator AND f.loja_id = 'Z443' WHERE cl.adms_store_id =:store ORDER BY cl.id DESC LIMIT :limit OFFSET :offset", "store={$_SESSION['usuario_loja']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listCheckList->getResult();
        return $this->Resultado;
    }
}
