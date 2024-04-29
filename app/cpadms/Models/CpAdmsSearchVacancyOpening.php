<?php

namespace App\cpadms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of CpAdmsSearchVacancyOpening
 *
 * @copyright (c) year, Chiralnio Silva - Grupo Meia Sola
 */
class CpAdmsSearchVacancyOpening {

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

        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'search-vacancy-opening/list', "?search={$this->Dados['search']}");
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        if ($_SESSION['ordem_nivac'] < STOREPERMITION) {
            $paginacao->paginacao("SELECT COUNT(op.id) AS num_result FROM adms_vacancy_opening op LEFT JOIN tb_lojas l ON l.id = op.adms_loja_id LEFT JOIN adms_sits_vacancy sv ON sv.id = op.adms_sit_vacancy_id LEFT JOIN adms_cors c ON c.id = sv.adms_cor_id LEFT JOIN adms_request_types rt ON rt.id = op.adms_request_type_id LEFT JOIN tb_cargos carg ON carg.id = op.adms_cargo_id WHERE op.id =:id OR l.nome LIKE '%' :store '%' OR sv.name_sit LIKE '%' :status '%' OR rt.type_name LIKE '%' :type_name '%'", "id={$this->Dados['search']}&store={$this->Dados['search']}&status={$this->Dados['search']}&type_name={$this->Dados['search']}");
        } else {
            $paginacao->paginacao("SELECT COUNT(o.id) AS num_result FROM adms_vacancy_opening op LEFT JOIN tb_lojas l ON l.id = op.adms_loja_id LEFT JOIN adms_sits_vacancy sv ON sv.id = op.adms_sit_vacancy_id LEFT JOIN adms_cors c ON c.id = sv.adms_cor_id LEFT JOIN adms_request_types rt ON rt.id = op.adms_request_type_id LEFT JOIN tb_cargos carg ON carg.id = op.adms_cargo_id WHERE op.adms_loja_id =:loja_id AND (o.id =:id OR l.nome LIKE '%' :nome '%' OR se.name_sit LIKE '%' :status '%')", "loja_id={$_SESSION['usuario_loja']}&id={$this->Dados['search']}&store={$this->Dados['search']}&status={$this->Dados['search']}&type_name={$this->Dados['search']}");
        }
        $this->ResultadoPg = $paginacao->getResultado();

        $listOrder = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] < STOREPERMITION) {
            $listOrder->fullRead("SELECT op.id v_id, l.nome name_store, sv.name_sit, c.cor cor_cr, rt.type_name, carg.nome cargo FROM adms_vacancy_opening op LEFT JOIN tb_lojas l ON l.id = op.adms_loja_id LEFT JOIN adms_sits_vacancy sv ON sv.id = op.adms_sit_vacancy_id LEFT JOIN adms_cors c ON c.id = sv.adms_cor_id LEFT JOIN adms_request_types rt ON rt.id = op.adms_request_type_id LEFT JOIN tb_cargos carg ON carg.id = op.adms_cargo_id WHERE op.id =:id OR l.nome LIKE '%' :store '%' OR sv.name_sit LIKE '%' :status '%' OR rt.type_name LIKE '%' :type_name '%' ORDER BY op.id DESC LIMIT :limit OFFSET :offset", "id={$this->Dados['search']}&store={$this->Dados['search']}&status={$this->Dados['search']}&type_name={$this->Dados['search']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        } else {
            $listOrder->fullRead("SELECT op.id v_id, l.nome name_store, sv.name_sit, c.cor cor_cr, rt.type_name, carg.nome cargo FROM adms_vacancy_opening op LEFT JOIN tb_lojas l ON l.id = op.adms_loja_id LEFT JOIN adms_sits_vacancy sv ON sv.id = op.adms_sit_vacancy_id LEFT JOIN adms_cors c ON c.id = sv.adms_cor_id LEFT JOIN adms_request_types rt ON rt.id = op.adms_request_type_id LEFT JOIN tb_cargos carg ON carg.id = op.adms_cargo_id WHERE op.adms_loja_id =:loja_id AND (op.id =:id OR l.nome LIKE '%' :store '%' OR sv.name_sit LIKE '%' :status '%' OR rt.type_name LIKE '%' :type_name '%') ORDER BY op.id DESC LIMIT :limit OFFSET :offset", "loja_id={$_SESSION['usuario_loja']}&id={$this->Dados['search']}&store={$this->Dados['search']}&status={$this->Dados['search']}&type_name={$this->Dados['search']}&limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        }
        $this->Resultado = $listOrder->getResult();
    }
}
