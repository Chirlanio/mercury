<?php

namespace App\cpadms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CpAdmsSearchSupplier
 *
 * @copyright (c) year, Chiralnio Silva - Grupo Meia Sola
 */
class CpAdmsSearchSupplier {

    private $Dados;
    private $Resultado;
    private $PageId;
    private $LimiteResultado = LIMIT;
    private $ResultadoPg;

    function getResultado() {
        return $this->ResultadoPg;
    }

    public function list($PageId = null, $Dados = null) {

        $this->PageId = (int) $PageId;
        $this->Dados = $Dados;

        $this->Dados['searchSupplier'] = trim($this->Dados['searchSupplier']);

        $_SESSION['searchSupplier'] = $this->Dados['searchSupplier'];

        if (!empty($this->Dados['searchSupplier'])) {
            $this->searchSupplier();
        }
        return $this->Resultado;
    }

    private function searchSupplier() {

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'search-supplier/list', '?search=' . $this->Dados['searchSupplier']);
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(id) AS num_result FROM adms_suppliers WHERE (corporate_social LIKE '%' :corporate_social '%' OR fantasy_name LIKE '%' :fantasy_name '%' OR cnpj_cpf LIKE '%' :cnpj_cpf '%') AND status_id =:status_id", "corporate_social={$this->Dados['searchSupplier']}&fantasy_name={$this->Dados['searchSupplier']}&cnpj_cpf={$this->Dados['searchSupplier']}&status_id=1");
        $this->ResultadoPg = $paginacao->getResultado();

        $listarOrderService = new \App\adms\Models\helper\AdmsRead();
        $listarOrderService->fullRead("SELECT supp.id id_supp, supp.corporate_social, supp.fantasy_name, supp.cnpj_cpf, s.nome status, c.cor FROM adms_suppliers supp LEFT JOIN adms_sits s ON s.id = supp.status_id LEFT JOIN adms_cors c ON c.id = s.adms_cor_id WHERE (supp.corporate_social LIKE '%' :corporate_social '%' OR supp.fantasy_name LIKE '%' :fantasy_name '%' OR supp.cnpj_cpf LIKE '%' :cnpj_cpf '%') AND supp.status_id =:status_id ORDER BY supp.id ASC LIMIT :limit OFFSET :offset", "corporate_social={$this->Dados['searchSupplier']}&fantasy_name={$this->Dados['searchSupplier']}&cnpj_cpf={$this->Dados['searchSupplier']}&status_id=1&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listarOrderService->getResultado();
    }
}
