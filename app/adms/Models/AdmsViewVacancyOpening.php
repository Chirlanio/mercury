<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsViewVacancyOpening
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsViewVacancyOpening {

    private $Resultado;
    private $DadosId;

    /**
     * <b>View Vacancy Opening:</b> Receber o id da solicitação de abertura de vagas para buscar informações do registro no banco de dados
     * @param int $DadosId
     */
    public function viewOrder($DadosId) {
        $this->DadosId = (int) $DadosId;
        $viewVacancy = new \App\adms\Models\helper\AdmsRead();
        $viewVacancy->fullRead("SELECT vop.*, l.nome store_name, f.nome employee_name, sv.name_sit status, co.cor cor_cr, car.nome cargo_nome, rt.type_name, sch.schedules, rec.recruiter_name, us.apelido FROM adms_vacancy_opening vop LEFT JOIN tb_lojas l ON l.id = vop.adms_loja_id LEFT JOIN tb_funcionarios f ON f.id = vop.adms_employee_id LEFT JOIN adms_sits_vacancy sv ON sv.id = vop.adms_sit_vacancy_id LEFT JOIN adms_cors co ON co.id = sv.adms_cor_id LEFT JOIN tb_cargos car ON car.id = vop.adms_cargo_id LEFT JOIN adms_request_types rt ON rt.id = vop.adms_request_type_id LEFT JOIN adms_work_schedules sch ON sch.id = vop.adms_work_schedule_id LEFT JOIN adms_recruiters rec ON rec.id = vop.adms_recruiter_id LEFT JOIN adms_usuarios us ON us.id = vop.updated_by WHERE vop.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $viewVacancy->getResult();
        return $this->Resultado;
    }
}
