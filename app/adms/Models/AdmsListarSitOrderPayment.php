<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListarSitOrderPayment
 *
 * @copyright (c) Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListarSitOrderPayment {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = LIMIT;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function listarSitOrderPayment($PageId = null) {
        $this->PageId = (int) $PageId;
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'situacao-order-payment/listar');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_sits_order_payments");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarSit = new \App\adms\Models\helper\AdmsRead();
        $listarSit->fullRead("SELECT o.id, o.exibition_name, o.order_sit, s.nome status FROM adms_sits_order_payments o INNER JOIN adms_sits s ON s.id = o.status_id ORDER BY o.order_sit ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarSit->getResult();
        return $this->Resultado;
    }

}
