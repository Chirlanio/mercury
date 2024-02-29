<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsListEcommerceOrder
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsListEcommerceOrder {

    private $Resultado;
    private $PageId;
    private $LimiteResultado = LIMIT;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function list($PageId = null) {

        $this->PageId = (int) $PageId;

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'ecommerce/list');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_ecommerce_orders WHERE loja_id =:loja_id", "loja_id=" . $_SESSION['usuario_loja']);
        } else {
            $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_ecommerce_orders");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listEcommerce = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $listEcommerce->fullRead("SELECT e.*, l.nome store, se.name status, c.cor cor_cr
                FROM adms_ecommerce_orders e
                LEFT JOIN tb_lojas l ON l.id = e.loja_id
                LEFT JOIN adms_sits_ecommerce se ON se.id = e.adms_sit_ecommerce_id
                LEFT JOIN adms_cors c ON c.id = se.adms_cor_id
                WHERE e.loja_id =:loja_id
                ORDER BY e.id DESC LIMIT :limit OFFSET :offset", "loja_id={$_SESSION['usuario_loja']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listEcommerce->fullRead("SELECT e.*, l.nome store, se.name status, c.cor cor_cr
                FROM adms_ecommerce_orders e
                LEFT JOIN tb_lojas l ON l.id = e.loja_id
                LEFT JOIN adms_sits_ecommerce se ON se.id = e.adms_sit_ecommerce_id
                LEFT JOIN adms_cors c ON c.id = se.adms_cor_id
                ORDER BY e.id DESC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listEcommerce->getResultado();
        return $this->Resultado;
    }

    public function listAdd() {

        $listar = new \App\adms\Models\helper\AdmsRead();

        if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION) {
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

        $this->Resultado = ['loja_id' => $registro['loja_id'], 'sit' => $registro['sit'], 'backlog' => $registro['backlog'], 'doing' => $registro['doing'], 'waiting' => $registro['waiting'], 'done' => $registro['done']];

        return $this->Resultado;
    }
}
