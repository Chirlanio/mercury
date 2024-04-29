<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsAddVacancyOpening
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsAddVacancyOpening {

    private $Resultado;
    private $Dados;
    private $Employee;
    private $CargoId;
    private $Comments;

    function getResultado() {
        return $this->Resultado;
    }

    public function addVacancy(array $Dados) {

        $this->Dados = $Dados;

        $this->Employee = $this->Dados['adms_employee_id'];
        $this->Comments = $this->Dados['comments'];
        unset($this->Dados['adms_employee_id'], $this->Dados['comments']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->insertVacancy();
        } else {
            $this->Resultado = false;
        }
    }

    private function insertVacancy() {

        $this->viewCargo($this->Dados['adms_cargo_id']);
        $this->Dados['adms_employee_id'] = !empty($this->Employee) ? $this->Employee : null;
        $this->Dados['delivery_forecast'] = date('Y-m-d', strtotime(date("Y-m-d") . '+20 days'));
        $this->Dados['created_by'] = $_SESSION['usuario_id'];
        $this->Dados['created'] = date("Y-m-d H:i:s");

        $addType = new \App\adms\Models\helper\AdmsCreate;
        $addType->exeCreate("adms_vacancy_opening", $this->Dados);

        if ($addType->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Abertura de Vaga</strong> cadastrada com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Abertura de vaga não cadastrada com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    private function viewCargo($cargoId) {
        $this->CargoId = (int) $cargoId;

        $viewCargo = new \App\adms\Models\helper\AdmsRead();
        $viewCargo->fullRead("SELECT adms_niv_cargo_id FROM tb_cargos WHERE id =:id LIMIT :limit", "id={$this->CargoId}&limit=1");
        $viewResult = $viewCargo->getResult();

        if ($viewResult[0]['adms_niv_cargo_id'] == 2) {
            $this->Dados['predicted_sla'] = 20;
        } else {
            $this->Dados['predicted_sla'] = 40;
        }
    }

    public function listAdd() {

        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id s_id, schedules schedule_name FROM adms_work_schedules");
        $registro['sched'] = $listar->getResult();

        $listar->fullRead("SELECT id s_id, nome status FROM adms_sits ORDER BY id ASC");
        $registro['sits'] = $listar->getResult(); //adms_recruiters

        $listar->fullRead("SELECT id r_id, type_name FROM adms_request_types");
        $registro['typeRequests'] = $listar->getResult();

        $listar->fullRead("SELECT id c_id, nome cargo_name FROM tb_cargos ORDER BY cargo_name ASC");
        $registro['cargos'] = $listar->getResult();

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

        $this->Resultado = ['sits' => $registro['sits'], 'typeRequests' => $registro['typeRequests'],
            'cargos' => $registro['cargos'], 'sched' => $registro['sched'], 'stores' => $registro['stores'],
            'employees' => $registro['employees'], 'recruiters' => $registro['recruiters']];

        return $this->Resultado;
    }
}
