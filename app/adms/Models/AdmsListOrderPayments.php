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
    private $LimiteResultado = 20;
    private $ResultadoPg;
    private $Backlog;
    private $Doing;
    private $Waiting;
    private $Done;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listBacklog($PageId = null) {

        $this->PageId = (int) $PageId;

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'order-payments/list');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_order_payments");
        $this->ResultadoPg = $paginacao->getResultado();

        $valueBacklog = new \App\adms\Models\helper\AdmsRead();
        $valueBacklog->fullRead("SELECT SUM(total_value) AS total_pay FROM adms_order_payments");
        $this->Backlog = $valueBacklog->getResultado();

        $listBacklog = new \App\adms\Models\helper\AdmsRead();
        $listBacklog->fullRead("SELECT op.*, a.name area, s.corporate_social fornecedor FROM adms_order_payments op LEFT JOIN adms_areas a ON a.id=op.adms_area_id LEFT JOIN adms_suppliers s ON s.id = op.adms_supplier_id WHERE op.adms_sits_order_pay_id =:adms_sits_order_pay_id ORDER BY op.id ASC LIMIT :limit OFFSET :offset", "adms_sits_order_pay_id=1&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");

        $this->Resultado = $listBacklog->getResultado();
        return $this->Resultado;
    }

    public function listDoing($PageId = null) {

        $this->PageId = (int) $PageId;
        
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'order-payments/list');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_order_payments");
        $this->ResultadoPg = $paginacao->getResultado();

        $valueDoing = new \App\adms\Models\helper\AdmsRead();
        $valueDoing->fullRead("SELECT SUM(total_value) AS total_pay FROM adms_order_payments");
        $this->Doing = $valueDoing->getResultado();

        $listBacklog = new \App\adms\Models\helper\AdmsRead();
        $listBacklog->fullRead("SELECT op.*, a.name area, s.corporate_social fornecedor FROM adms_order_payments op LEFT JOIN adms_areas a ON a.id=op.adms_area_id LEFT JOIN adms_suppliers s ON s.id = op.adms_supplier_id WHERE op.adms_sits_order_pay_id =:adms_sits_order_pay_id ORDER BY op.id ASC LIMIT :limit OFFSET :offset", "adms_sits_order_pay_id=1&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");

        $this->Resultado = $listBacklog->getResultado();
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

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'sit' => $registro['sit']];

        return $this->Resultado;
    }

}
