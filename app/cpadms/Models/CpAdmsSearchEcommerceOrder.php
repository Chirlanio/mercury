<?php

namespace App\cpadms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CpAdmsSearchEcommerceOrder
 *
 * @copyright (c) year, Chiralnio Silva - Grupo Meia Sola
 */
class CpAdmsSearchEcommerceOrder {

    private $Dados;
    private $Resultado;
    private $PageId;
    private $LimiteResultado = LIMIT;
    private $Terms;
    private $ResultadoPg;

    function getResultado() {
        return $this->ResultadoPg;
    }

    public function list($PageId = null, $Dados = null) {

        $this->PageId = (int) $PageId;
        $this->Dados = $Dados;

        $this->Dados['search'] = trim($this->Dados['search']);

        $this->Terms = "?search={$this->Dados['search']}";

        $_SESSION['search'] = $this->Dados['search'];

        if (!empty($this->Dados['search'])) {
            $this->search();
        }
        return $this->Resultado;
    }

    private function search() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'search-ecommerce-order/list', "?search={$this->Dados['search']}");
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= ADMPERMITION) {
            $paginacao->paginacao("SELECT COUNT(e.id) AS num_result FROM adms_ecommerce_orders e LEFT JOIN tb_lojas l ON l.id = e.loja_id LEFT JOIN adms_sits_ecommerce se ON se.id = e.adms_sit_ecommerce_id WHERE e.id =:id OR l.nome LIKE '%' :nome '%' OR se.name LIKE '%' :status '%'","id={$this->Dados['search']}&nome={$this->Dados['search']}&status={$this->Dados['search']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(e.id) AS num_result FROM adms_ecommerce_orders e LEFT JOIN tb_lojas l ON l.id = e.loja_id LEFT JOIN adms_sits_ecommerce se ON se.id = e.adms_sit_ecommerce_id WHERE loja_id =:loja_id AND (e.id =:id OR l.nome LIKE '%' :nome '%' OR se.name LIKE '%' :status '%')","loja_id={$_SESSION['usuario_loja']}&id={$this->Dados['search']}&nome={$this->Dados['search']}&status={$this->Dados['search']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrder = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= ADMPERMITION) {
            $listOrder->fullRead("SELECT e.*, l.nome store, se.name status, c.cor cor_cr FROM adms_ecommerce_orders e LEFT JOIN tb_lojas l ON l.id = e.loja_id LEFT JOIN adms_sits_ecommerce se ON se.id = e.adms_sit_ecommerce_id LEFT JOIN adms_cors c ON c.id = se.adms_cor_id WHERE e.id =:id OR l.nome LIKE '%' :nome '%' OR se.name LIKE '%' :status '%' ORDER BY e.id DESC LIMIT :limit OFFSET :offset", "id={$this->Dados['search']}&nome={$this->Dados['search']}&status={$this->Dados['search']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }  else {
            $listOrder->fullRead("SELECT e.*, l.nome store, se.name status, c.cor cor_cr FROM adms_ecommerce_orders e LEFT JOIN tb_lojas l ON l.id = e.loja_id LEFT JOIN adms_sits_ecommerce se ON se.id = e.adms_sit_ecommerce_id LEFT JOIN adms_cors c ON c.id = se.adms_cor_id WHERE e.loja_id =:loja_id AND (e.id =:id OR l.nome LIKE '%' :nome '%' OR se.name LIKE '%' :status '%') ORDER BY e.id DESC LIMIT :limit OFFSET :offset", "loja_id={$_SESSION['usuario_loja']}&id={$this->Dados['search']}&nome={$this->Dados['search']}&status={$this->Dados['search']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listOrder->getResultado();
    }
}
