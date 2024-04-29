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
class CpAdmsGenerateExcelSpreadsheet {

    private $Resultado;
    private $Dados;
    private $PageId;
    private $LimiteResultado = 1048576;
    private $ResultadoPg;

    function getResultadoPg() {
        return $this->ResultadoPg;
    }

    public function list($PageId = null, $Dados = null) {

        $this->PageId = (int) $PageId;
        $this->Dados = $Dados;

        $this->search();
        return $this->Resultado;
    }

    private function search() {
        $paginacao = new \App\adms\Models\helper\AdmsPaginacao(URLADM . 'genarate-excel-spreadsheet/genarate-excel');
        $paginacao->condicao($this->PageId, $this->LimiteResultado);
        $paginacao->paginacao("SELECT COUNT(d.id) AS num_result FROM adms_vacancy_opening d");
        $this->ResultadoPg = $paginacao->getResultado();

        $listVacancy = new \App\adms\Models\helper\AdmsRead();
        $listVacancy->fullRead("SELECT vop.id vop_id, vop.delivery_forecast, vop.interview_hr, vop.evaluators_hr, vop.interview_leader, vop.evaluators_leader, vop.approved, vop.comments, vop.closing_date, vop.predicted_sla, vop.effective_sla, vop.created, vop.modified, typ.type_name, func.nome emploee, lj.nome store, carg.nome cargo, sch.schedules, rec.recruiter_name, vc.name_sit, user.nome creator, us.nome updater FROM adms_vacancy_opening vop LEFT JOIN adms_request_types typ ON typ.id = vop.adms_request_type_id LEFT JOIN tb_funcionarios func ON func.id = vop.adms_employee_id LEFT JOIN tb_lojas lj ON lj.id = vop.adms_loja_id LEFT JOIN tb_cargos carg ON carg.id = vop.adms_cargo_id LEFT JOIN adms_work_schedules sch ON sch.id = vop.adms_work_schedule_id LEFT JOIN adms_recruiters rec ON rec.id = vop.adms_recruiter_id LEFT JOIN adms_sits_vacancy vc ON vc.id = vop.adms_sit_vacancy_id LEFT JOIN adms_usuarios user ON user.id = vop.created_by LEFT JOIN adms_usuarios us ON us.id = vop.updated_by ORDER BY vop.id ASC LIMIT :limit OFFSET :offset", "limit={$this->LimiteResultado}&offset={$paginacao->getOffset()}");
        $this->Resultado = $listVacancy->getResult();
    }
}
