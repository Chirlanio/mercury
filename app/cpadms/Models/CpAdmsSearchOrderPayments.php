<?php

namespace App\cpadms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CpAdmsSearchOrderPayments
 *
 * @copyright (c) year, Chiralnio Silva - Grupo Meia Sola
 */
class CpAdmsSearchOrderPayments {

    private $Dados;
    private $Resultado;
    private $PageId;
    private $LimiteResultado = LIMIT;
    private $Terms;
    private $ResultadoPg;

    function getResultado() {
        return $this->ResultadoPg;
    }

    public function listBacklog($PageId = null, $Dados = null) {

        $this->PageId = (int) $PageId;
        $this->Dados = $Dados;

        $this->Dados['search'] = trim($this->Dados['search']);
        if (empty($this->Dados['searchDateInitial']) and empty($this->Dados['searchDateFinal'])) {
            
        }

        $_SESSION['search'] = $this->Dados['search'];
        $_SESSION['searchDateInitial'] = !empty($this->Dados['searchDateInitial']) ? $this->Dados['searchDateInitial'] : '2023-01-01';
        $_SESSION['searchDateFinal'] = !empty($this->Dados['searchDateFinal']) ? $this->Dados['searchDateFinal'] : date("Y-m-d");

        if ((!empty($this->Dados['search'])) and (!empty($this->Dados['searchDateInitial'])) and (!empty($this->Dados['searchDateFinal']))) {
            $this->Terms = "?search={$this->Dados['search']}&searchDateInitial={$this->Dados['searchDateInitial']}&searchDateFinal={$this->Dados['searchDateFinal']}";
        } else if ((empty($this->Dados['search'])) and (!empty($this->Dados['searchDateInitial'])) and (!empty($this->Dados['searchDateFinal']))) {
            $this->Terms = "?searchDateInitial={$this->Dados['searchDateInitial']}&searchDateFinal={$this->Dados['searchDateFinal']}";
        } else if ((!empty($this->Dados['search'])) and (empty($this->Dados['searchDateInitial'])) and (empty($this->Dados['searchDateFinal']))) {
            $this->Terms = "?search={$this->Dados['search']}";
        } else {
            $this->Terms = null;
        }
        $_SESSION['terms'] = $this->Terms;

        if (!empty($this->Dados['search']) || ((!empty($this->Dados['searchDateInitial'])) && (!empty($this->Dados['searchDateFinal'])))) {
            $this->searchBacklog();
        }
        return $this->Resultado;
    }

    private function searchBacklog() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'search-order-payments/list', $this->Terms);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ((!empty($this->Dados['searchDateInitial'])) and (!empty($this->Dados['searchDateFinal'])) and (empty($this->Dados['search']))) {
            $paginacao->paginacao("SELECT COUNT(op.id) / COUNT(DISTINCT(op.adms_sits_order_pay_id)) AS num_result FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (op.date_payment BETWEEN :searchDateInitial AND :searchDateFinal) AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id", "searchDateInitial={$this->Dados['searchDateInitial']}&searchDateFinal={$this->Dados['searchDateFinal']}&adms_sits_order_pay_id=1");
        } else if ((empty($this->Dados['searchDateInitial'])) and (empty($this->Dados['searchDateFinal'])) and (!empty($this->Dados['search']))) {
            $paginacao->paginacao("SELECT COUNT(op.id) / COUNT(DISTINCT(op.adms_sits_order_pay_id)) AS num_result FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (op.total_value =:total_value OR sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id", "total_value={$this->Dados['search']}&fantasy_name={$this->Dados['search']}&corporate_social={$this->Dados['search']}&id={$this->Dados['search']}&area={$this->Dados['search']}&costCenter={$this->Dados['search']}&adms_sits_order_pay_id=1");
        } else {
            $paginacao->paginacao("SELECT COUNT(op.id) / COUNT(DISTINCT(op.adms_sits_order_pay_id)) AS num_result FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (op.total_value =:total_value OR sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.date_payment BETWEEN :searchDateInitial AND :searchDateFinal AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id", "total_value={$this->Dados['search']}&fantasy_name={$this->Dados['search']}&corporate_social={$this->Dados['search']}&id={$this->Dados['search']}&area={$this->Dados['search']}&costCenter={$this->Dados['search']}&searchDateInitial={$this->Dados['searchDateInitial']}&searchDateFinal={$this->Dados['searchDateFinal']}&adms_sits_order_pay_id=1");
        }

        $this->ResultadoPg = $paginacao->getResultado();

        $listOrder = new \App\adms\Models\helper\AdmsRead();
        if ((!empty($this->Dados['searchDateInitial'])) and (!empty($this->Dados['searchDateFinal'])) and (empty($this->Dados['search']))) {
            $listOrder->fullRead("SELECT op.id bk_id, op.total_value total_bk, op.advance adv_bk, op.proof proof_bk, op.created_date created_date_bk, op.date_payment date_payment_bk, op.installments installments_bk, op.advance_amount advance_amount_bk, op.diff_payment_advance diff_payment_advance_bk, sp.fantasy_name fornecedor_bk, a.name area_bk, payment_prepared payment_prepared_bk FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (op.date_payment BETWEEN :searchDateInitial AND :searchDateFinal) AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id ORDER BY op.id ASC LIMIT :limit OFFSET :offset", "searchDateInitial={$this->Dados['searchDateInitial']}&searchDateFinal={$this->Dados['searchDateFinal']}&adms_sits_order_pay_id=1&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else if ((empty($this->Dados['searchDateInitial'])) and (empty($this->Dados['searchDateFinal'])) and (!empty($this->Dados['search']))) {
            $listOrder->fullRead("SELECT op.id bk_id, op.total_value total_bk, op.advance adv_bk, op.proof proof_bk, op.created_date created_date_bk, op.date_payment date_payment_bk, op.installments installments_bk, op.advance_amount advance_amount_bk, op.diff_payment_advance diff_payment_advance_bk, sp.fantasy_name fornecedor_bk, a.name area_bk, payment_prepared payment_prepared_bk FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (op.total_value =:total_value OR sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id", "total_value={$this->Dados['search']}&fantasy_name={$this->Dados['search']}&corporate_social={$this->Dados['search']}&id={$this->Dados['search']}&area={$this->Dados['search']}&costCenter={$this->Dados['search']}&adms_sits_order_pay_id=1");
        } else {
            $listOrder->fullRead("SELECT op.id bk_id, op.total_value total_bk, op.advance adv_bk, op.proof proof_bk, op.created_date created_date_bk, op.date_payment date_payment_bk, op.installments installments_bk, op.advance_amount advance_amount_bk, op.diff_payment_advance diff_payment_advance_bk, sp.fantasy_name fornecedor_bk, a.name area_bk, payment_prepared payment_prepared_bk FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (op.total_value =:total_value OR sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.date_payment BETWEEN :searchDateInitial AND :searchDateFinal AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id", "total_value={$this->Dados['search']}&fantasy_name={$this->Dados['search']}&corporate_social={$this->Dados['search']}&id={$this->Dados['search']}&area={$this->Dados['search']}&costCenter={$this->Dados['search']}&searchDateInitial={$this->Dados['searchDateInitial']}&searchDateFinal={$this->Dados['searchDateFinal']}&adms_sits_order_pay_id=1");
        }
        $this->Resultado = $listOrder->getResult();
    }

    public function listDoing($PageId = null, $Dados = null) {

        $this->PageId = (int) $PageId;
        $this->Dados = $Dados;

        $this->Dados['search'] = trim($this->Dados['search']);

        $_SESSION['search'] = $this->Dados['search'];
        if ((!empty($this->Dados['search'])) and (!empty($this->Dados['searchDateInitial'])) and (!empty($this->Dados['searchDateFinal']))) {
            $this->Terms = "?search={$this->Dados['search']}&searchDateInitial={$this->Dados['searchDateInitial']}&searchDateFinal={$this->Dados['searchDateFinal']}";
        } else if ((empty($this->Dados['search'])) and (!empty($this->Dados['searchDateInitial'])) and (!empty($this->Dados['searchDateFinal']))) {
            $this->Terms = "?searchDateInitial={$this->Dados['searchDateInitial']}&searchDateFinal={$this->Dados['searchDateFinal']}";
        } else if ((!empty($this->Dados['search'])) and (empty($this->Dados['searchDateInitial'])) and (empty($this->Dados['searchDateFinal']))) {
            $this->Terms = "?search={$this->Dados['search']}";
        } else {
            $this->Terms = null;
        }
        $_SESSION['terms'] = $this->Terms;

        if (!empty($this->Dados['search']) || ((!empty($this->Dados['searchDateInitial'])) && (!empty($this->Dados['searchDateFinal'])))) {
            $this->searchDoing();
        }
        return $this->Resultado;
    }

    private function searchDoing() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'search-order-payments/list', $this->Terms);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ((!empty($this->Dados['searchDateInitial'])) and (!empty($this->Dados['searchDateFinal'])) and (empty($this->Dados['search']))) {
            $paginacao->paginacao("SELECT COUNT(op.id) / COUNT(DISTINCT(op.adms_sits_order_pay_id)) AS num_result FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (op.adms_sits_order_pay_id =:adms_sits_order_pay_id) AND op.date_payment BETWEEN :searchDateInitial AND :searchDateFinal", "searchDateInitial={$this->Dados['searchDateInitial']}&searchDateFinal={$this->Dados['searchDateFinal']}&adms_sits_order_pay_id=2");
        } else if ((empty($this->Dados['searchDateInitial'])) and (empty($this->Dados['searchDateFinal'])) and (!empty($this->Dados['search']))) {
            $paginacao->paginacao("SELECT COUNT(op.id) / COUNT(DISTINCT(op.adms_sits_order_pay_id)) AS num_result FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (op.total_value =:total_value OR sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id", "total_value={$this->Dados['search']}&fantasy_name={$this->Dados['search']}&corporate_social={$this->Dados['search']}&id={$this->Dados['search']}&area={$this->Dados['search']}&costCenter={$this->Dados['search']}&adms_sits_order_pay_id=2");
        } else {
            $paginacao->paginacao("SELECT COUNT(op.id) / COUNT(DISTINCT(op.adms_sits_order_pay_id)) AS num_result FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (op.total_value =:total_value OR sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.date_payment BETWEEN :searchDateInitial AND :searchDateFinal AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id", "total_value={$this->Dados['search']}&fantasy_name={$this->Dados['search']}&corporate_social={$this->Dados['search']}&id={$this->Dados['search']}&area={$this->Dados['search']}&costCenter={$this->Dados['search']}&searchDateInitial={$this->Dados['searchDateInitial']}&searchDateFinal={$this->Dados['searchDateFinal']}&adms_sits_order_pay_id=2");
        }

        $this->ResultadoPg = $paginacao->getResultado();

        $listOrder = new \App\adms\Models\helper\AdmsRead();
        if ((!empty($this->Dados['searchDateInitial'])) and (!empty($this->Dados['searchDateFinal'])) and (empty($this->Dados['search']))) {
            $listOrder->fullRead("SELECT op.id do_id, op.total_value total_do, op.advance adv_do, op.proof proof_do, op.created_date created_date_do, op.date_payment date_payment_do, op.installments installments_do, op.advance_amount advance_amount_do, op.diff_payment_advance diff_payment_advance_do, sp.fantasy_name fornecedor_do, a.name area_do, payment_prepared payment_prepared_do FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (op.date_payment BETWEEN :searchDateInitial AND :searchDateFinal) AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id ORDER BY op.id ASC LIMIT :limit OFFSET :offset", "searchDateInitial={$this->Dados['searchDateInitial']}&searchDateFinal={$this->Dados['searchDateFinal']}&adms_sits_order_pay_id=2&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else if ((empty($this->Dados['searchDateInitial'])) and (empty($this->Dados['searchDateFinal'])) and (!empty($this->Dados['search']))) {
            $listOrder->fullRead("SELECT op.id do_id, op.total_value total_do, op.advance adv_do, op.proof proof_do, op.created_date created_date_do, op.date_payment date_payment_do, op.installments installments_do, op.advance_amount advance_amount_do, op.diff_payment_advance diff_payment_advance_do, sp.fantasy_name fornecedor_do, a.name area_do, payment_prepared payment_prepared_do FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (op.total_value =:total_value OR sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id", "total_value={$this->Dados['search']}&fantasy_name={$this->Dados['search']}&corporate_social={$this->Dados['search']}&id={$this->Dados['search']}&area={$this->Dados['search']}&costCenter={$this->Dados['search']}&adms_sits_order_pay_id=2");
        } else {
            $listOrder->fullRead("SELECT op.id do_id, op.total_value total_do, op.advance adv_do, op.proof proof_do, op.created_date created_date_do, op.date_payment date_payment_do, op.installments installments_do, op.advance_amount advance_amount_do, op.diff_payment_advance diff_payment_advance_do, sp.fantasy_name fornecedor_do, a.name area_do, payment_prepared payment_prepared_do FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (op.total_value =:total_value OR sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.date_payment BETWEEN :searchDateInitial AND :searchDateFinal AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id", "total_value={$this->Dados['search']}&fantasy_name={$this->Dados['search']}&corporate_social={$this->Dados['search']}&id={$this->Dados['search']}&area={$this->Dados['search']}&costCenter={$this->Dados['search']}&searchDateInitial={$this->Dados['searchDateInitial']}&searchDateFinal={$this->Dados['searchDateFinal']}&adms_sits_order_pay_id=2");
        }
        $this->Resultado = $listOrder->getResult();
    }

    public function listWaiting($PageId = null, $Dados = null) {

        $this->PageId = (int) $PageId;
        $this->Dados = $Dados;

        $this->Dados['search'] = trim($this->Dados['search']);

        $_SESSION['search'] = $this->Dados['search'];
        if ((!empty($this->Dados['search'])) and (!empty($this->Dados['searchDateInitial'])) and (!empty($this->Dados['searchDateFinal']))) {
            $this->Terms = "?search={$this->Dados['search']}&searchDateInitial={$this->Dados['searchDateInitial']}&searchDateFinal={$this->Dados['searchDateFinal']}";
        } else if ((empty($this->Dados['search'])) and (!empty($this->Dados['searchDateInitial'])) and (!empty($this->Dados['searchDateFinal']))) {
            $this->Terms = "?searchDateInitial={$this->Dados['searchDateInitial']}&searchDateFinal={$this->Dados['searchDateFinal']}";
        } else if ((!empty($this->Dados['search'])) and (empty($this->Dados['searchDateInitial'])) and (empty($this->Dados['searchDateFinal']))) {
            $this->Terms = "?search={$this->Dados['search']}";
        } else {
            $this->Terms = null;
        }
        $_SESSION['terms'] = $this->Terms;

        if (!empty($this->Dados['search']) || ((!empty($this->Dados['searchDateInitial'])) && (!empty($this->Dados['searchDateFinal'])))) {
            $this->searchWaiting();
        }
        return $this->Resultado;
    }

    private function searchWaiting() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'search-order-payments/list', $this->Terms);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ((!empty($this->Dados['searchDateInitial'])) and (!empty($this->Dados['searchDateFinal'])) and (empty($this->Dados['search']))) {
            $paginacao->paginacao("SELECT COUNT(op.id) / COUNT(DISTINCT(op.adms_sits_order_pay_id)) AS num_result FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (op.adms_sits_order_pay_id =:adms_sits_order_pay_id) AND op.date_payment BETWEEN :searchDateInitial AND :searchDateFinal", "searchDateInitial={$this->Dados['searchDateInitial']}&searchDateFinal={$this->Dados['searchDateFinal']}&adms_sits_order_pay_id=3");
        } else if ((empty($this->Dados['searchDateInitial'])) and (empty($this->Dados['searchDateFinal'])) and (!empty($this->Dados['search']))) {
            $paginacao->paginacao("SELECT COUNT(op.id) / COUNT(DISTINCT(op.adms_sits_order_pay_id)) AS num_result FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (op.total_value =:total_value OR sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id", "total_value={$this->Dados['search']}&fantasy_name={$this->Dados['search']}&corporate_social={$this->Dados['search']}&id={$this->Dados['search']}&area={$this->Dados['search']}&costCenter={$this->Dados['search']}&adms_sits_order_pay_id=3");
        } else {
            $paginacao->paginacao("SELECT COUNT(op.id) / COUNT(DISTINCT(op.adms_sits_order_pay_id)) AS num_result FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (op.total_value =:total_value OR sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.date_payment BETWEEN :searchDateInitial AND :searchDateFinal AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id", "total_value={$this->Dados['search']}&fantasy_name={$this->Dados['search']}&corporate_social={$this->Dados['search']}&id={$this->Dados['search']}&area={$this->Dados['search']}&costCenter={$this->Dados['search']}&searchDateInitial={$this->Dados['searchDateInitial']}&searchDateFinal={$this->Dados['searchDateFinal']}&adms_sits_order_pay_id=3");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrder = new \App\adms\Models\helper\AdmsRead();
        if ((!empty($this->Dados['searchDateInitial'])) and (!empty($this->Dados['searchDateFinal'])) and (empty($this->Dados['search']))) {
            $listOrder->fullRead("SELECT op.id wa_id, op.total_value total_wa, op.advance adv_wa, op.proof proof_wa, op.created_date created_date_wa, op.date_payment date_payment_wa, op.installments installments_wa, op.advance_amount advance_amount_wa, op.diff_payment_advance diff_payment_advance_wa, sp.fantasy_name fornecedor_wa, a.name area_wa, payment_prepared payment_prepared_wa FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (op.date_payment BETWEEN :searchDateInitial AND :searchDateFinal) AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id ORDER BY op.id ASC LIMIT :limit OFFSET :offset", "searchDateInitial={$this->Dados['searchDateInitial']}&searchDateFinal={$this->Dados['searchDateFinal']}&adms_sits_order_pay_id=3&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else if ((empty($this->Dados['searchDateInitial'])) and (empty($this->Dados['searchDateFinal'])) and (!empty($this->Dados['search']))) {
            $listOrder->fullRead("SELECT op.id wa_id, op.total_value total_wa, op.advance adv_wa, op.proof proof_wa, op.created_date created_date_wa, op.date_payment date_payment_wa, op.installments installments_wa, op.advance_amount advance_amount_wa, op.diff_payment_advance diff_payment_advance_wa, sp.fantasy_name fornecedor_wa, a.name area_wa, payment_prepared payment_prepared_wa FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (op.total_value =:total_value OR sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id", "total_value={$this->Dados['search']}&fantasy_name={$this->Dados['search']}&corporate_social={$this->Dados['search']}&id={$this->Dados['search']}&area={$this->Dados['search']}&costCenter={$this->Dados['search']}&adms_sits_order_pay_id=3");
        } else {
            $listOrder->fullRead("SELECT op.id wa_id, op.total_value total_wa, op.advance adv_wa, op.proof proof_wa, op.created_date created_date_wa, op.date_payment date_payment_wa, op.installments installments_wa, op.advance_amount advance_amount_wa, op.diff_payment_advance diff_payment_advance_wa, sp.fantasy_name fornecedor_wa, a.name area_wa, payment_prepared payment_prepared_wa FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (op.total_value =:total_value OR sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.date_payment BETWEEN :searchDateInitial AND :searchDateFinal AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id", "total_value={$this->Dados['search']}&fantasy_name={$this->Dados['search']}&corporate_social={$this->Dados['search']}&id={$this->Dados['search']}&area={$this->Dados['search']}&costCenter={$this->Dados['search']}&searchDateInitial={$this->Dados['searchDateInitial']}&searchDateFinal={$this->Dados['searchDateFinal']}&adms_sits_order_pay_id=3");
        }
        $this->Resultado = $listOrder->getResult();
    }

    public function listDone($PageId = null, $Dados = null) {

        $this->PageId = (int) $PageId;
        $this->Dados = $Dados;

        $this->Dados['search'] = trim($this->Dados['search']);

        $_SESSION['search'] = $this->Dados['search'];
        if ((!empty($this->Dados['search'])) and (!empty($this->Dados['searchDateInitial'])) and (!empty($this->Dados['searchDateFinal']))) {
            $this->Terms = "?search={$this->Dados['search']}&searchDateInitial={$this->Dados['searchDateInitial']}&searchDateFinal={$this->Dados['searchDateFinal']}";
        } else if ((empty($this->Dados['search'])) and (!empty($this->Dados['searchDateInitial'])) and (!empty($this->Dados['searchDateFinal']))) {
            $this->Terms = "?searchDateInitial={$this->Dados['searchDateInitial']}&searchDateFinal={$this->Dados['searchDateFinal']}";
        } else if ((!empty($this->Dados['search'])) and (empty($this->Dados['searchDateInitial'])) and (empty($this->Dados['searchDateFinal']))) {
            $this->Terms = "?search={$this->Dados['search']}";
        } else {
            $this->Terms = null;
        }
        $_SESSION['terms'] = $this->Terms;

        if (!empty($this->Dados['search']) || ((!empty($this->Dados['searchDateInitial'])) && (!empty($this->Dados['searchDateFinal'])))) {
            $this->searchDone();
        }
        return $this->Resultado;
    }

    private function searchDone() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'search-order-payments/list', $this->Terms);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ((!empty($this->Dados['searchDateInitial'])) and (!empty($this->Dados['searchDateFinal'])) and (empty($this->Dados['search']))) {
            $paginacao->paginacao("SELECT COUNT(op.id) / COUNT(DISTINCT(op.adms_sits_order_pay_id)) AS num_result FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (op.adms_sits_order_pay_id =:adms_sits_order_pay_id) AND op.date_payment BETWEEN :searchDateInitial AND :searchDateFinal", "searchDateInitial={$this->Dados['searchDateInitial']}&searchDateFinal={$this->Dados['searchDateFinal']}&adms_sits_order_pay_id=4");
        } else if ((empty($this->Dados['searchDateInitial'])) and (empty($this->Dados['searchDateFinal'])) and (!empty($this->Dados['search']))) {
            $paginacao->paginacao("SELECT COUNT(op.id) / COUNT(DISTINCT(op.adms_sits_order_pay_id)) AS num_result FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (op.total_value =:total_value OR sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id", "total_value={$this->Dados['search']}&fantasy_name={$this->Dados['search']}&corporate_social={$this->Dados['search']}&id={$this->Dados['search']}&area={$this->Dados['search']}&costCenter={$this->Dados['search']}&adms_sits_order_pay_id=4");
        } else {
            $paginacao->paginacao("SELECT COUNT(op.id) / COUNT(DISTINCT(op.adms_sits_order_pay_id)) AS num_result FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (op.total_value =:total_value OR sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.date_payment BETWEEN :searchDateInitial AND :searchDateFinal AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id", "total_value={$this->Dados['search']}&fantasy_name={$this->Dados['search']}&corporate_social={$this->Dados['search']}&id={$this->Dados['search']}&area={$this->Dados['search']}&costCenter={$this->Dados['search']}&searchDateInitial={$this->Dados['searchDateInitial']}&searchDateFinal={$this->Dados['searchDateFinal']}&adms_sits_order_pay_id=4");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrder = new \App\adms\Models\helper\AdmsRead();
        if ((!empty($this->Dados['searchDateInitial'])) and (!empty($this->Dados['searchDateFinal'])) and (empty($this->Dados['search']))) {
            $listOrder->fullRead("SELECT op.id don_id, op.total_value total_don, op.advance adv_don, op.proof proof_don, op.created_date created_date_don, op.date_payment date_payment_don, op.installments installments_don, op.advance_amount advance_amount_don, op.diff_payment_advance diff_payment_advance_don, sp.fantasy_name fornecedor_don, a.name area_don, payment_prepared payment_prepared_don FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (op.date_payment BETWEEN :searchDateInitial AND :searchDateFinal) AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id ORDER BY op.id ASC LIMIT :limit OFFSET :offset", "searchDateInitial={$this->Dados['searchDateInitial']}&searchDateFinal={$this->Dados['searchDateFinal']}&adms_sits_order_pay_id=4&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else if ((empty($this->Dados['searchDateInitial'])) and (empty($this->Dados['searchDateFinal'])) and (!empty($this->Dados['search']))) {
            $listOrder->fullRead("SELECT op.id don_id, op.total_value total_don, op.advance adv_don, op.proof proof_don, op.created_date created_date_don, op.date_payment date_payment_don, op.installments installments_don, op.advance_amount advance_amount_don, op.diff_payment_advance diff_payment_advance_don, sp.fantasy_name fornecedor_don, a.name area_don, payment_prepared payment_prepared_don FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (op.total_value =:total_value OR sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id", "total_value={$this->Dados['search']}&fantasy_name={$this->Dados['search']}&corporate_social={$this->Dados['search']}&id={$this->Dados['search']}&area={$this->Dados['search']}&costCenter={$this->Dados['search']}&adms_sits_order_pay_id=4");
        } else {
            $listOrder->fullRead("SELECT op.id don_id, op.total_value total_don, op.advance adv_don, op.proof proof_don, op.created_date created_date_don, op.date_payment date_payment_don, op.installments installments_don, op.advance_amount advance_amount_don, op.diff_payment_advance diff_payment_advance_don, sp.fantasy_name fornecedor_don, a.name area_don, payment_prepared payment_prepared_don FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (op.total_value =:total_value OR sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.date_payment BETWEEN :searchDateInitial AND :searchDateFinal AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id", "total_value={$this->Dados['search']}&fantasy_name={$this->Dados['search']}&corporate_social={$this->Dados['search']}&id={$this->Dados['search']}&area={$this->Dados['search']}&costCenter={$this->Dados['search']}&searchDateInitial={$this->Dados['searchDateInitial']}&searchDateFinal={$this->Dados['searchDateFinal']}&adms_sits_order_pay_id=4");
        }
        $this->Resultado = $listOrder->getResult();
    }

    public function listAdd() {

        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT SUM(op.total_value) AS total_backlog FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.date_payment BETWEEN :searchDateInitial AND :searchDateFinal AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id", "adms_sits_order_pay_id=1&fantasy_name=" . $_SESSION['search'] . "&corporate_social=" . $_SESSION['search'] . "&id=" . $_SESSION['search'] . "&area=" . $_SESSION['search'] . "&costCenter=" . $_SESSION['search'] . "&searchDateInitial=" . $_SESSION['searchDateInitial'] . "&searchDateFinal=" . $_SESSION['searchDateFinal']);
        $registro['backlog'] = $listar->getResult();

        $listar->fullRead("SELECT SUM(op.total_value) AS total_doing FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.date_payment BETWEEN :searchDateInitial AND :searchDateFinal AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id", "adms_sits_order_pay_id=2&fantasy_name=" . $_SESSION['search'] . "&corporate_social=" . $_SESSION['search'] . "&id=" . $_SESSION['search'] . "&area=" . $_SESSION['search'] . "&costCenter=" . $_SESSION['search'] . "&searchDateInitial=" . $_SESSION['searchDateInitial'] . "&searchDateFinal=" . $_SESSION['searchDateFinal']);
        $registro['doing'] = $listar->getResult();

        $listar->fullRead("SELECT SUM(op.total_value) AS total_waiting FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.date_payment BETWEEN :searchDateInitial AND :searchDateFinal AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id", "adms_sits_order_pay_id=3&fantasy_name=" . $_SESSION['search'] . "&corporate_social=" . $_SESSION['search'] . "&id=" . $_SESSION['search'] . "&area=" . $_SESSION['search'] . "&costCenter=" . $_SESSION['search'] . "&searchDateInitial=" . $_SESSION['searchDateInitial'] . "&searchDateFinal=" . $_SESSION['searchDateFinal']);
        $registro['waiting'] = $listar->getResult();

        $listar->fullRead("SELECT SUM(total_value) AS total_done FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.date_payment BETWEEN :searchDateInitial AND :searchDateFinal AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id", "adms_sits_order_pay_id=4&fantasy_name=" . $_SESSION['search'] . "&corporate_social=" . $_SESSION['search'] . "&id=" . $_SESSION['search'] . "&area=" . $_SESSION['search'] . "&costCenter=" . $_SESSION['search'] . "&searchDateInitial=" . $_SESSION['searchDateInitial'] . "&searchDateFinal=" . $_SESSION['searchDateFinal']);
        $registro['done'] = $listar->getResult();

        $this->Resultado = ['backlog' => $registro['backlog'], 'doing' => $registro['doing'], 'waiting' => $registro['waiting'], 'done' => $registro['done']];

        return $this->Resultado;
    }
}
