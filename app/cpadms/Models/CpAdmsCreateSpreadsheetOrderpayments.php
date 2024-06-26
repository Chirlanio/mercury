<?php

namespace App\cpadms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CpAdmsCreateSpreadsheetOrderpayments
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class CpAdmsCreateSpreadsheetOrderpayments {

    private $Resultado;
    private $Dados;
    private $PageId;
    private $LimiteResultado = 1048576;
    private $Terms;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function list($PageId = null, $Dados = null) {

        $this->PageId = (int) $PageId;
        $this->Dados = $Dados;

        $_SESSION['search'] = trim($this->Dados['search']);
        $_SESSION['searchDateInitial'] = $this->Dados['searchDateInitial'];
        $_SESSION['searchDateFinal'] = $this->Dados['searchDateFinal'];
        
        if ((!empty($this->Dados['search'])) and (!empty($this->Dados['searchDateInitial'])) and (!empty($this->Dados['searchDateFinal']))) {
            $this->Terms = "?search={$this->Dados['search']}&searchDateInitial={$this->Dados['searchDateInitial']}&searchDateFinal={$this->Dados['searchDateFinal']}";
        } else if ((empty($this->Dados['search'])) and (!empty($this->Dados['searchDateInitial'])) and (!empty($this->Dados['searchDateFinal']))) {
            $this->Terms = "?searchDateInit={$this->Dados['searchDateInitial']}&searchDateFinal={$this->Dados['searchDateFinal']}";
        } else if ((!empty($this->Dados['search'])) and (empty($this->Dados['searchDateInitial'])) and (empty($this->Dados['searchDateFinal']))) {
            $this->Terms = "?search={$this->Dados['search']}";
        } else {
            $this->Terms = null;
        }
        $_SESSION['terms'] = $this->Terms;

        $this->search();
        return $this->Resultado;
    }

    private function search() {
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'create-spreadsheet-order-payments/create', $_SESSION['terms']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ((!empty($this->Dados['search'])) AND (empty($this->Dados['searchDateInitial'])) AND (empty($this->Dados['searchDateFinal']))) {
            $paginacao->paginacao("SELECT COUNT(op.id) / COUNT(DISTINCT(op.adms_sits_order_pay_id)) AS num_result FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE ((op.total_value =:total_value) OR sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%')", "total_value={$this->Dados['search']}&fantasy_name={$this->Dados['search']}&corporate_social={$this->Dados['search']}&id={$this->Dados['search']}&area={$this->Dados['search']}&costCenter={$this->Dados['search']}");
        }else if ((empty($this->Dados['search'])) AND (!empty($this->Dados['searchDateInitial'])) AND (!empty($this->Dados['searchDateFinal']))) {
            $paginacao->paginacao("SELECT COUNT(op.id) / COUNT(DISTINCT(op.adms_sits_order_pay_id)) AS num_result FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE op.date_payment BETWEEN :searchDateInitial AND :searchDateFinal", "searchDateInitial={$this->Dados['searchDateInitial']}&searchDateFinal={$this->Dados['searchDateFinal']}");
        }else if ((!empty($this->Dados['search'])) AND (!empty($this->Dados['searchDateInitial'])) AND (!empty($this->Dados['searchDateFinal']))) {
            $paginacao->paginacao("SELECT COUNT(op.id) / COUNT(DISTINCT(op.adms_sits_order_pay_id)) AS num_result FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (op.total_value =:total_value OR sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.date_payment BETWEEN :searchDateInitial AND :searchDateFinal", "total_value={$this->Dados['search']}&fantasy_name={$this->Dados['search']}&corporate_social={$this->Dados['search']}&id={$this->Dados['search']}&area={$this->Dados['search']}&costCenter={$this->Dados['search']}&searchDateInitial={$this->Dados['searchDateInitial']}&searchDateFinal={$this->Dados['searchDateFinal']}");
        }else{
            $paginacao->paginacao("SELECT COUNT(op.id) / COUNT(DISTINCT(op.adms_sits_order_pay_id)) AS num_result FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrder = new \App\adms\Models\helper\AdmsRead();
        if ((!empty($this->Dados['search'])) AND (!empty($this->Dados['searchDateInitial'])) AND (!empty($this->Dados['searchDateFinal']))) {
            $listOrder->fullRead("SELECT op.id op_id, op.date_payment, op.description, op.total_value, op.name_supplier, op.agency, op.checking_account checking, op.key_pix, op.advance, op.advance_amount, op.number_nf, op.file_name, op.created, op.modified, op.diff_payment_advance, a.name area, cc.name costCenter, sp.fantasy_name supplier, bs.brand, m.name manager, tp.name typePayment, tk.name typeKey, so.exibition_name sit, user.nome create_user, func.nome update_user, payment_prepared FROM adms_order_payments op LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_brands_suppliers bs ON bs.id = op.adms_brand_id LEFT JOIN adms_managers m ON m.id = op.manager_id LEFT JOIN adms_type_payments tp ON tp.id = op.adms_type_payment_id LEFT JOIN adms_type_key_pixs tk ON tk.id = op.adms_type_key_pix_id LEFT JOIN adms_sits_order_payments so ON so.id = op.adms_sits_order_pay_id LEFT JOIN adms_usuarios user ON user.id = op.adms_user_id LEFT JOIN adms_usuarios func ON func.id = op.update_user_id WHERE (op.total_value =:total_value OR sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.date_payment BETWEEN :searchDateInitial AND :searchDateFinal ORDER BY op.date_payment ASC, op.id ASC, op.created ASC", "total_value={$this->Dados['search']}&fantasy_name={$this->Dados['search']}&corporate_social={$this->Dados['search']}&id={$this->Dados['search']}&area={$this->Dados['search']}&costCenter={$this->Dados['search']}&searchDateInitial={$this->Dados['searchDateInitial']}&searchDateFinal={$this->Dados['searchDateFinal']}");
        } else if((empty($this->Dados['search'])) AND (!empty($this->Dados['searchDateInitial'])) AND (!empty($this->Dados['searchDateFinal']))){
            $listOrder->fullRead("SELECT op.id op_id, op.date_payment, op.description, op.total_value, op.name_supplier, op.agency, op.checking_account checking, op.key_pix, op.advance, op.advance_amount, op.number_nf, op.file_name, op.created, op.modified, op.diff_payment_advance, a.name area, cc.name costCenter, sp.fantasy_name supplier, bs.brand, m.name manager, tp.name typePayment, tk.name typeKey, so.exibition_name sit, user.nome create_user, func.nome update_user, payment_prepared FROM adms_order_payments op LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_brands_suppliers bs ON bs.id = op.adms_brand_id LEFT JOIN adms_managers m ON m.id = op.manager_id LEFT JOIN adms_type_payments tp ON tp.id = op.adms_type_payment_id LEFT JOIN adms_type_key_pixs tk ON tk.id = op.adms_type_key_pix_id LEFT JOIN adms_sits_order_payments so ON so.id = op.adms_sits_order_pay_id LEFT JOIN adms_usuarios user ON user.id = op.adms_user_id LEFT JOIN adms_usuarios func ON func.id = op.update_user_id WHERE op.date_payment BETWEEN :searchDateInitial AND :searchDateFinal ORDER BY op.date_payment ASC, op.id ASC, op.created ASC", "searchDateInitial={$this->Dados['searchDateInitial']}&searchDateFinal={$this->Dados['searchDateFinal']}");
        }else if((!empty($this->Dados['search'])) AND (empty($this->Dados['searchDateInitial'])) AND (empty($this->Dados['searchDateFinal']))) {
            $listOrder->fullRead("SELECT op.id op_id, op.date_payment, op.description, op.total_value, op.name_supplier, op.agency, op.checking_account checking, op.key_pix, op.advance, op.advance_amount, op.number_nf, op.file_name, op.created, op.modified, op.diff_payment_advance, a.name area, cc.name costCenter, sp.fantasy_name supplier, bs.brand, m.name manager, tp.name typePayment, tk.name typeKey, so.exibition_name sit, user.nome create_user, func.nome update_user, payment_prepared FROM adms_order_payments op LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_brands_suppliers bs ON bs.id = op.adms_brand_id LEFT JOIN adms_managers m ON m.id = op.manager_id LEFT JOIN adms_type_payments tp ON tp.id = op.adms_type_payment_id LEFT JOIN adms_type_key_pixs tk ON tk.id = op.adms_type_key_pix_id LEFT JOIN adms_sits_order_payments so ON so.id = op.adms_sits_order_pay_id LEFT JOIN adms_usuarios user ON user.id = op.adms_user_id LEFT JOIN adms_usuarios func ON func.id = op.update_user_id WHERE (op.total_value =:total_value OR sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') ORDER BY op.date_payment ASC, op.id ASC, op.created ASC", "total_value={$this->Dados['search']}&fantasy_name={$this->Dados['search']}&corporate_social={$this->Dados['search']}&id={$this->Dados['search']}&area={$this->Dados['search']}&costCenter={$this->Dados['search']}");
        } else {
            $listOrder->fullRead("SELECT op.id op_id, op.date_payment, op.description, op.total_value, op.name_supplier, op.agency, op.checking_account checking, op.key_pix, op.advance, op.advance_amount, op.number_nf, op.file_name, op.created, op.modified, op.diff_payment_advance, a.name area, cc.name costCenter, sp.fantasy_name supplier, bs.brand, m.name manager, tp.name typePayment, tk.name typeKey, so.exibition_name sit, user.nome create_user, func.nome update_user, payment_prepared FROM adms_order_payments op LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_brands_suppliers bs ON bs.id = op.adms_brand_id LEFT JOIN adms_managers m ON m.id = op.manager_id LEFT JOIN adms_type_payments tp ON tp.id = op.adms_type_payment_id LEFT JOIN adms_type_key_pixs tk ON tk.id = op.adms_type_key_pix_id LEFT JOIN adms_sits_order_payments so ON so.id = op.adms_sits_order_pay_id LEFT JOIN adms_usuarios user ON user.id = op.adms_user_id LEFT JOIN adms_usuarios func ON func.id = op.update_user_id ORDER BY op.date_payment ASC, op.id ASC, op.created ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listOrder->getResult();
    }
}
