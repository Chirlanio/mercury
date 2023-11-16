<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarEstorno
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListOrderPayments {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = LIMIT;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listBacklog($PageId = null) {

        $this->PageId = (int) $PageId;

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'order-payments/list');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) / COUNT(DISTINCT(adms_sits_order_pay_id)) AS num_result FROM adms_order_payments");
        $this->ResultadoPg = $paginacao->getResultado();

        $listBacklog = new \App\adms\Models\helper\AdmsRead();
        $listBacklog->fullRead("SELECT op.*, a.name area_backlog, s.corporate_social fornecedor_backlog FROM adms_order_payments op LEFT JOIN adms_areas a ON a.id=op.adms_area_id LEFT JOIN adms_suppliers s ON s.id = op.adms_supplier_id WHERE op.adms_sits_order_pay_id =:adms_sits_order_pay_id ORDER BY op.id ASC LIMIT :limit OFFSET :offset", "adms_sits_order_pay_id=1&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");

        $this->Resultado = $listBacklog->getResultado();
        return $this->Resultado;
    }

    public function listDoing($PageId = null) {

        $this->PageId = (int) $PageId;
        
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'order-payments/list');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) / COUNT(DISTINCT(adms_sits_order_pay_id)) AS num_result FROM adms_order_payments");
        $this->ResultadoPg = $paginacao->getResultado();

        $listDoing = new \App\adms\Models\helper\AdmsRead();
        $listDoing->fullRead("SELECT op.*, a.name area_doing, s.corporate_social fornecedor_doing FROM adms_order_payments op LEFT JOIN adms_areas a ON a.id=op.adms_area_id LEFT JOIN adms_suppliers s ON s.id = op.adms_supplier_id WHERE op.adms_sits_order_pay_id =:adms_sits_order_pay_id ORDER BY op.id ASC LIMIT :limit OFFSET :offset", "adms_sits_order_pay_id=2&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");

        $this->Resultado = $listDoing->getResultado();
        return $this->Resultado;
    }

    public function listWaiting($PageId = null) {

        $this->PageId = (int) $PageId;
        
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'order-payments/list');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) / COUNT(DISTINCT(adms_sits_order_pay_id)) AS num_result FROM adms_order_payments");
        $this->ResultadoPg = $paginacao->getResultado();

        $listWaiting = new \App\adms\Models\helper\AdmsRead();
        $listWaiting->fullRead("SELECT op.*, a.name area_waiting, s.corporate_social fornecedor_waiting FROM adms_order_payments op LEFT JOIN adms_areas a ON a.id=op.adms_area_id LEFT JOIN adms_suppliers s ON s.id = op.adms_supplier_id WHERE op.adms_sits_order_pay_id =:adms_sits_order_pay_id ORDER BY op.id ASC LIMIT :limit OFFSET :offset", "adms_sits_order_pay_id=3&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");

        $this->Resultado = $listWaiting->getResultado();
        return $this->Resultado;
    }

    public function listDone($PageId = null) {

        $this->PageId = (int) $PageId;
        
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'order-payments/list');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) / COUNT(DISTINCT(adms_sits_order_pay_id)) AS num_result FROM adms_order_payments");
        $this->ResultadoPg = $paginacao->getResultado();

        $listDone = new \App\adms\Models\helper\AdmsRead();
        $listDone->fullRead("SELECT op.*, a.name area_done, s.corporate_social fornecedor_done FROM adms_order_payments op LEFT JOIN adms_areas a ON a.id=op.adms_area_id LEFT JOIN adms_suppliers s ON s.id = op.adms_supplier_id WHERE op.adms_sits_order_pay_id =:adms_sits_order_pay_id ORDER BY op.id ASC LIMIT :limit OFFSET :offset", "adms_sits_order_pay_id=4&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");

        $this->Resultado = $listDone->getResultado();
        return $this->Resultado;
    }

    public function listAdd() {

        $listar = new \App\adms\Models\helper\AdmsRead();

        if ($_SESSION['ordem_nivac'] <= 5) {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas WHERE rede_id <=:rede_id AND status_id =:status_id ORDER BY id ASC", "rede_id=6&status_id=1");
        } else {
            $listar->fullRead("SELECT id loja_id, nome loja FROM tb_lojas WHERE id =:id AND status_id =:status_id ORDER BY id ASC", "id=" . $_SESSION['usuario_loja'] . "&status_id=1");
        }
        $registro['loja_id'] = $listar->getResultado();

        $listar->fullRead("SELECT id sit_id, nome sit FROM adms_sits_estornos ORDER BY id ASC");
        $registro['sit'] = $listar->getResultado();
        
        $listar->fullRead("SELECT SUM(total_value) AS total_backlog FROM adms_order_payments WHERE adms_sits_order_pay_id =:adms_sits_order_pay_id", "adms_sits_order_pay_id=1");
        $registro['backlog'] = $listar->getResultado();
        
        $listar->fullRead("SELECT SUM(total_value) AS total_doing FROM adms_order_payments WHERE adms_sits_order_pay_id =:adms_sits_order_pay_id", "adms_sits_order_pay_id=2");
        $registro['doing'] = $listar->getResultado();
        
        $listar->fullRead("SELECT SUM(total_value) AS total_waiting FROM adms_order_payments WHERE adms_sits_order_pay_id =:adms_sits_order_pay_id", "adms_sits_order_pay_id=3");
        $registro['waiting'] = $listar->getResultado();
        
        $listar->fullRead("SELECT SUM(total_value) AS total_done FROM adms_order_payments WHERE adms_sits_order_pay_id =:adms_sits_order_pay_id", "adms_sits_order_pay_id=4");
        $registro['done'] = $listar->getResultado();

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'sit' => $registro['sit'], 'backlog' => $registro['backlog'], 'doing' => $registro['doing'], 'waiting' => $registro['waiting'], 'done' =>$registro['done']];

        return $this->Resultado;
    }

}
