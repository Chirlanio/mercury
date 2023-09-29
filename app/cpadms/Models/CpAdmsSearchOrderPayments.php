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
    private $LimiteResultado = 20;
    private $ResultadoPg;

    function getResultado() {
        return $this->ResultadoPg;
    }

    public function listBacklog($PageId = null, $Dados = null) {

        $this->PageId = (int) $PageId;
        $this->Dados = $Dados;

        $this->Dados['search'] = trim($this->Dados['search']);

        $_SESSION['search'] = $this->Dados['search'];

        if (!empty($this->Dados['search'])) {
            $this->searchBacklog();
        }
        return $this->Resultado;
    }

    private function searchBacklog() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'search-order-payments/list', '?search=' . $this->Dados['search']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(op.id) / COUNT(DISTINCT(op.adms_sits_order_pay_id)) AS num_result FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id", "fantasy_name={$this->Dados['search']}&corporate_social={$this->Dados['search']}&id={$this->Dados['search']}&area={$this->Dados['search']}&costCenter={$this->Dados['search']}&adms_sits_order_pay_id=1");
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrder = new \App\adms\Models\helper\AdmsRead();
        $listOrder->fullRead("SELECT op.*, sp.fantasy_name fornecedor_backlog, a.name area_backlog FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id ORDER BY op.id ASC LIMIT :limit OFFSET :offset", "fantasy_name={$this->Dados['search']}&corporate_social={$this->Dados['search']}&id={$this->Dados['search']}&area={$this->Dados['search']}&costCenter={$this->Dados['search']}&adms_sits_order_pay_id=1&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");

        $this->Resultado = $listOrder->getResultado();
    }

    public function listDoing($PageId = null, $Dados = null) {

        $this->PageId = (int) $PageId;
        $this->Dados = $Dados;

        $this->Dados['search'] = trim($this->Dados['search']);

        $_SESSION['search'] = $this->Dados['search'];

        if (!empty($this->Dados['search'])) {
            $this->searchDoing();
        }
        return $this->Resultado;
    }

    private function searchDoing() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'search-order-payments/list', '?search=' . $_SESSION['search']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(op.id) / COUNT(DISTINCT(op.adms_sits_order_pay_id)) AS num_result FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id", "fantasy_name={$this->Dados['search']}&corporate_social={$this->Dados['search']}&id={$this->Dados['search']}&area={$this->Dados['search']}&costCenter={$this->Dados['search']}&adms_sits_order_pay_id=2");
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrder = new \App\adms\Models\helper\AdmsRead();
        $listOrder->fullRead("SELECT op.*, sp.fantasy_name fornecedor_doing, a.name area_doing FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id ORDER BY op.id ASC LIMIT :limit OFFSET :offset", "fantasy_name={$this->Dados['search']}&corporate_social={$this->Dados['search']}&id={$this->Dados['search']}&area={$this->Dados['search']}&costCenter={$this->Dados['search']}&adms_sits_order_pay_id=2&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");

        $this->Resultado = $listOrder->getResultado();
    }

    public function listWaiting($PageId = null, $Dados = null) {

        $this->PageId = (int) $PageId;
        $this->Dados = $Dados;

        $this->Dados['search'] = trim($this->Dados['search']);

        $_SESSION['search'] = $this->Dados['search'];

        if (!empty($this->Dados['search'])) {
            $this->searchWaiting();
        }
        return $this->Resultado;
    }

    private function searchWaiting() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'search-order-payments/list', '?search=' . $_SESSION['search']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(op.id) / COUNT(DISTINCT(op.adms_sits_order_pay_id)) AS num_result FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id", "fantasy_name={$this->Dados['search']}&corporate_social={$this->Dados['search']}&id={$this->Dados['search']}&area={$this->Dados['search']}&costCenter={$this->Dados['search']}&adms_sits_order_pay_id=3");
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrder = new \App\adms\Models\helper\AdmsRead();
        $listOrder->fullRead("SELECT op.*, sp.fantasy_name fornecedor_waiting, a.name area_waiting FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id ORDER BY op.id ASC LIMIT :limit OFFSET :offset", "fantasy_name={$this->Dados['search']}&corporate_social={$this->Dados['search']}&id={$this->Dados['search']}&area={$this->Dados['search']}&costCenter={$this->Dados['search']}&adms_sits_order_pay_id=3&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");

        $this->Resultado = $listOrder->getResultado();
    }

    public function listDone($PageId = null, $Dados = null) {

        $this->PageId = (int) $PageId;
        $this->Dados = $Dados;

        $this->Dados['search'] = trim($this->Dados['search']);

        $_SESSION['search'] = $this->Dados['search'];

        if (!empty($this->Dados['search'])) {
            $this->searchDone();
        }
        return $this->Resultado;
    }

    private function searchDone() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'search-order-payments/list', '?search=' . $_SESSION['search']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(op.id) / COUNT(DISTINCT(op.adms_sits_order_pay_id)) AS num_result FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id", "fantasy_name={$this->Dados['search']}&corporate_social={$this->Dados['search']}&id={$this->Dados['search']}&area={$this->Dados['search']}&costCenter={$this->Dados['search']}&adms_sits_order_pay_id=4");
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrder = new \App\adms\Models\helper\AdmsRead();
        $listOrder->fullRead("SELECT op.*, sp.fantasy_name fornecedor_done, a.name area_done FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id ORDER BY op.id ASC LIMIT :limit OFFSET :offset", "fantasy_name={$this->Dados['search']}&corporate_social={$this->Dados['search']}&id={$this->Dados['search']}&area={$this->Dados['search']}&costCenter={$this->Dados['search']}&adms_sits_order_pay_id=4&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");

        $this->Resultado = $listOrder->getResultado();
    }

    public function listAdd() {

        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT SUM(op.total_value) AS total_backlog FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id", "adms_sits_order_pay_id=1&fantasy_name=" . $_SESSION['search'] . "&corporate_social=" . $_SESSION['search'] . "&id=" . $_SESSION['search'] . "&area=" . $_SESSION['search'] . "&costCenter=" . $_SESSION['search']);
        $registro['backlog'] = $listar->getResultado();

        $listar->fullRead("SELECT SUM(op.total_value) AS total_doing FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id", "adms_sits_order_pay_id=2&fantasy_name=" . $_SESSION['search'] . "&corporate_social=" . $_SESSION['search'] . "&id=" . $_SESSION['search'] . "&area=" . $_SESSION['search'] . "&costCenter=" . $_SESSION['search']);
        $registro['doing'] = $listar->getResultado();

        $listar->fullRead("SELECT SUM(op.total_value) AS total_waiting FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id", "adms_sits_order_pay_id=3&fantasy_name=" . $_SESSION['search'] . "&corporate_social=" . $_SESSION['search'] . "&id=" . $_SESSION['search'] . "&area=" . $_SESSION['search'] . "&costCenter=" . $_SESSION['search']);
        $registro['waiting'] = $listar->getResultado();

        $listar->fullRead("SELECT SUM(total_value) AS total_done FROM adms_order_payments op LEFT JOIN adms_suppliers sp ON sp.id = op.adms_supplier_id LEFT JOIN adms_areas a ON a.id = op.adms_area_id LEFT JOIN adms_cost_centers cc ON cc.id = op.adms_cost_center_id WHERE (sp.fantasy_name LIKE '%' :fantasy_name '%' OR sp.corporate_social LIKE '%' :corporate_social '%' OR op.id =:id OR a.name LIKE '%' :area '%' OR cc.name LIKE '%' :costCenter '%') AND op.adms_sits_order_pay_id =:adms_sits_order_pay_id", "adms_sits_order_pay_id=4&fantasy_name=" . $_SESSION['search'] . "&corporate_social=" . $_SESSION['search'] . "&id=" . $_SESSION['search'] . "&area=" . $_SESSION['search'] . "&costCenter=" . $_SESSION['search']);
        $registro['done'] = $listar->getResultado();

        $this->Resultado = ['backlog' => $registro['backlog'], 'doing' => $registro['doing'], 'waiting' => $registro['waiting'], 'done' => $registro['done']];

        return $this->Resultado;
    }
}
