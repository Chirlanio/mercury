<?php

namespace App\cpadms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CpAdmsSearchCheckList
 *
 * @copyright (c) year, Chiralnio Silva - Grupo Meia Sola
 */
class CpAdmsSearchCheckList {

    private array|object|null $Dados;
    private $Resultado;
    private $PageId;
    private $LimiteResultado = LIMIT;
    private $ResultadoPg;

    function getResultado() {
        return $this->ResultadoPg;
    }

    public function list($PageId = null, array|object|null $Dados = null) {

        $this->PageId = (int) $PageId;
        $this->Dados = $Dados;

        $this->Dados['search'] = trim($this->Dados['search']);

        $_SESSION['search'] = $this->Dados['search'];

        if (!empty($this->Dados['search'])) {
            $this->search();
        }
        return $this->Resultado;
    }

    private function search() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'search-check-list/list', "?search={$this->Dados['search']}");
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION) {
            $paginacao->paginacao("SELECT COUNT(m.id) AS num_result FROM adms_check_lists m LEFT JOIN tb_lojas l ON l.id = m.adms_store_id WHERE m.hash_id =:hash OR l.nome LIKE '%' :storeName '%'", "hash={$this->Dados['search']}&storeName={$this->Dados['search']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(m.id) AS num_result FROM adms_check_lists m LEFT JOIN tb_lojas l ON l.id = m.adms_store_id WHERE m.adms_store_id =:loja_id AND (m.hash_id =:hash OR l.nome LIKE '%' :storeName '%')", "loja_id={$_SESSION['usuario_loja']}&hash={$this->Dados['search']}&storeName={$this->Dados['search']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listCheckList = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION) {
            $listCheckList->fullRead("SELECT m.*, l.nome store, sp.name_sit status, c.cor cor_cr FROM adms_check_lists m LEFT JOIN tb_lojas l ON l.id = m.adms_store_id LEFT JOIN adms_sit_check_lists sp ON sp.id = m.adms_sit_check_list_id LEFT JOIN adms_cors c ON c.id = sp.adms_cor_id WHERE m.hash_id =:hash OR l.nome LIKE '%' :nameStore '%' ORDER BY m.id DESC LIMIT :limit OFFSET :offset", "hash={$this->Dados['search']}&nameStore={$this->Dados['search']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listCheckList->fullRead("SELECT m.*, l.nome store, sp.name_sit status, c.cor cor_cr FROM adms_check_lists m LEFT JOIN tb_lojas l ON l.id = m.adms_store_id LEFT JOIN adms_sit_check_lists sp ON sp.id = m.adms_sit_check_list_id LEFT JOIN adms_cors c ON c.id = sp.adms_cor_id WHERE m.adms_store_id =:loja_id AND (m.hash_id =:hash OR l.nome LIKE '%' :nameStore '%') ORDER BY m.id DESC LIMIT :limit OFFSET :offset", "loja_id={$_SESSION['usuario_loja']}&hash={$this->Dados['search']}&nameStore={$this->Dados['search']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listCheckList->getResult();
    }
}
