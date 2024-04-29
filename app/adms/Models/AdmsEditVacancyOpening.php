<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

use DateTime;

/**
 * Description of AdmsEditVacancyOpening
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meia Sola
 */
class AdmsEditVacancyOpening {

    private $Resultado;
    private $Dados;
    private $DadosId;
    private $Employee;
    private $Recruiter;
    private $InterviewHr;
    private $EvaluatorsHr;
    private $InterviewLeader;
    private $EvaluatorsLeader;
    private $Approved;
    private $Comments;
    private $ClosingDate;
    private $PreviewDate;

    function getResultado() {
        return $this->Resultado;
    }

    public function viewVacancy($DadosId) {
        $this->DadosId = (int) $DadosId;
        $viewVacancy = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['ordem_nivac'] <= FINANCIALPERMITION) {
            $viewVacancy->fullRead("SELECT vop.*, l.nome store_name, f.nome employee_name, sv.name_sit status, co.cor cor_cr, car.nome cargo_nome, rt.type_name, sch.schedules, rec.recruiter_name, us.apelido FROM adms_vacancy_opening vop LEFT JOIN tb_lojas l ON l.id = vop.adms_loja_id LEFT JOIN tb_funcionarios f ON f.id = vop.adms_employee_id LEFT JOIN adms_sits_vacancy sv ON sv.id = vop.adms_sit_vacancy_id LEFT JOIN adms_cors co ON co.id = sv.adms_cor_id LEFT JOIN tb_cargos car ON car.id = vop.adms_cargo_id LEFT JOIN adms_request_types rt ON rt.id = vop.adms_request_type_id LEFT JOIN adms_work_schedules sch ON sch.id = vop.adms_work_schedule_id LEFT JOIN adms_recruiters rec ON rec.id = vop.adms_recruiter_id LEFT JOIN adms_usuarios us ON us.id = vop.updated_by WHERE vop.id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        } else {
            $viewVacancy->fullRead("SELECT vop.*, l.nome store_name, f.nome employee_name, sv.name_sit status, co.cor cor_cr, car.nome cargo_nome, rt.type_name, sch.schedules, rec.recruiter_name, us.apelido FROM adms_vacancy_opening vop LEFT JOIN tb_lojas l ON l.id = vop.adms_loja_id LEFT JOIN tb_funcionarios f ON f.id = vop.adms_employee_id LEFT JOIN adms_sits_vacancy sv ON sv.id = vop.adms_sit_vacancy_id LEFT JOIN adms_cors co ON co.id = sv.adms_cor_id LEFT JOIN tb_cargos car ON car.id = vop.adms_cargo_id LEFT JOIN adms_request_types rt ON rt.id = vop.adms_request_type_id LEFT JOIN adms_work_schedules sch ON sch.id = vop.adms_work_schedule_id LEFT JOIN adms_recruiters rec ON rec.id = vop.adms_recruiter_id LEFT JOIN adms_usuarios us ON us.id = vop.updated_by WHERE vop.id =:id AND vop.adms_loja_id =:adms_loja_id AND vop.adms_sit_vacancy_id =:adms_sit_vacancy_id LIMIT :limit", "id={$this->DadosId}&adms_loja_id=" . $_SESSION['usuario_loja'] . "&adms_sit_vacancy_id=1&limit=1");
        }
        $this->Resultado = $viewVacancy->getResult();
        return $this->Resultado;
    }

    private function datePrev() {
        $datePrev = new \App\adms\Models\helper\AdmsRead();
        $datePrev->fullRead("SELECT id, closing_date, created FROM adms_vacancy_opening WHERE id =:id LIMIT :limit", "id={$this->Dados['id']}&limit=1");
        $this->PreviewDate = $datePrev->getResult();

        $data_inicio = new DateTime($this->PreviewDate[0]['created']);
        $data_fim = !empty($this->PreviewDate['closing_date']) ? new DateTime($this->PreviewDate['closing_date']) : new DateTime();

        // Resgata diferença entre as datas
        $slaEffective = $data_inicio->diff($data_fim);
        $this->Dados['effective_sla'] = $slaEffective->days;
        $this->PreviewDate = date("Y-m-d H:i:s", strtotime($this->PreviewDate[0]['created'] . "+{$this->Dados['predicted_sla']} days"));
        $this->Dados['delivery_forecast'] = $this->PreviewDate;
    }

    public function altVacancy(array $Dados) {
        $this->Dados = $Dados;
        $this->Employee = $this->Dados['adms_employee_id'];
        $this->Recruiter = $this->Dados['adms_recruiter_id'];
        $this->InterviewHr = !empty($this->Dados['interview_hr']) ? $this->Dados['interview_hr'] : null;
        $this->EvaluatorsHr = $this->Dados['evaluators_hr'];
        $this->InterviewLeader = !empty($this->Dados['interview_leader']) ? $this->Dados['interview_leader'] : null;
        $this->EvaluatorsLeader = $this->Dados['evaluators_leader'];
        $this->Approved = $this->Dados['approved'];
        $this->Comments = $this->Dados['comments'];
        $this->ClosingDate = !empty($this->Dados['closing_date']) ? $this->Dados['closing_date'] : null;

        $this->datePrev();

        unset($this->Dados['adms_employee_id'], $this->Dados['adms_recruiter_id'], $this->Dados['interview_hr'], $this->Dados['evaluators_hr'],
                $this->Dados['interview_leader'], $this->Dados['evaluators_leader'], $this->Dados['approved'], $this->Dados['closing_date'], $this->Dados['comments']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazioComTag();
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditVacancyOpening();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditVacancyOpening() {

        $this->Dados['adms_employee_id'] = $this->Employee;
        $this->Dados['adms_recruiter_id'] = $this->Recruiter;
        $this->Dados['interview_hr'] = $this->InterviewHr;
        $this->Dados['evaluators_hr'] = $this->EvaluatorsHr;
        $this->Dados['interview_leader'] = $this->InterviewLeader;
        $this->Dados['evaluators_leader'] = $this->EvaluatorsLeader;
        $this->Dados['approved'] = $this->Approved;
        $this->Dados['comments'] = $this->Comments;
        $this->Dados['closing_date'] = $this->ClosingDate;
        $this->Dados['updated_by'] = $_SESSION['usuario_id'];
        $this->Dados['modified'] = date("Y-m-d H:i:s");

        $upAltOrder = new \App\adms\Models\helper\AdmsUpdate();
        $upAltOrder->exeUpdate("adms_vacancy_opening", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltOrder->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Abertura de Vaga</strong> atualizada com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> A solicitação não foi atualizada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listAdd() {

        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id s_id, schedules schedule_name FROM adms_work_schedules");
        $registro['sched'] = $listar->getResult();

        $listar->fullRead("SELECT id s_id, name_sit FROM adms_sits_vacancy ORDER BY id ASC");
        $registro['sits'] = $listar->getResult(); //adms_recruiters

        $listar->fullRead("SELECT id r_id, type_name FROM adms_request_types");
        $registro['typeRequests'] = $listar->getResult();

        $listar->fullRead("SELECT id rec_id, recruiter_name FROM adms_recruiters WHERE adms_sit_id =:adms_sit_id", "adms_sit_id=1");
        $registro['recruiters'] = $listar->getResult();

        if ($_SESSION['ordem_nivac'] < STOREPERMITION) {
            $listar->fullRead("SELECT id lj_id, nome store FROM tb_lojas WHERE status_id =:status_id ORDER BY id ASC", "status_id=1");
            $registro['stores'] = $listar->getResult();
        } else {
            $listar->fullRead("SELECT id lj_id, nome store FROM tb_lojas WHERE id =:l_id AND status_id =:status_id ORDER BY id ASC", "l_id=" . $_SESSION['usuario_loja'] . "&status_id=1");
            $registro['stores'] = $listar->getResult();
        }

        if ($_SESSION['ordem_nivac'] < STOREPERMITION) {
            $listar->fullRead("SELECT id f_id, nome employee_name FROM tb_funcionarios WHERE status_id =:status_id ORDER BY id ASC", "status_id=1");
            $registro['employees'] = $listar->getResult();
        } else {
            $listar->fullRead("SELECT id f_id, nome employee_name FROM tb_funcionarios WHERE loja_id =:f_id AND status_id =:status_id ORDER BY id ASC", "f_id=" . $_SESSION['usuario_loja'] . "&status_id=1");
            $registro['employees'] = $listar->getResult();
        }

        $listar->fullRead("SELECT id c_id, nome cargo_name FROM tb_cargos WHERE adms_sit_id =:adms_sit_id ORDER BY nome ASC", "adms_sit_id=1");
        $registro['cargos'] = $listar->getResult();

        $this->Resultado = ['sits' => $registro['sits'], 'typeRequests' => $registro['typeRequests'],
            'cargos' => $registro['cargos'], 'sched' => $registro['sched'], 'stores' => $registro['stores'],
            'employees' => $registro['employees'], 'recruiters' => $registro['recruiters']];

        return $this->Resultado;
    }
}
