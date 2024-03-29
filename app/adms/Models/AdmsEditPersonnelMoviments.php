<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditPersonnelMoviments
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meia Sola
 */
class AdmsEditPersonnelMoviments {

    private $Resultado;
    private array|string|null $Dados;
    private int $DadosId;
    private string|null $Observation;
    private array|object|null $File;
    private array|string|null $Optional;
    private array|string|null $DismissalFollow;

    function getResultado() {
        return $this->Resultado;
    }

    public function viewMoviment($DadosId) {
        $this->DadosId = (int) $DadosId;
        $viewMoviment = new \App\adms\Models\helper\AdmsRead();
        if ($_SESSION['adms_niveis_acesso_id'] == SUPADMPERMITION) {
            $viewMoviment->fullRead("SELECT pm.id, pm.adms_loja_id, lj.nome store, pm.adms_area_id, pm.adms_employee_id, fc.nome colaborador, pm.last_day_worked, pm.adms_employee_relation_id, pm.adms_resignation_id, pm.early_warning_id, pm.fouls, pm.days_off, pm.folds, pm.fixed_fund, pm.access_power_bi, pm.access_zznet, pm.access_cigam, pm.access_camera, pm.access_deskfy, pm.access_meu_atendimento, pm.access_dito, pm.notebook, pm.email_corporate, pm.office_parking_card, pm.office_parking_shopping, pm.key_office, pm.key_store, pm.instagram_corporate, pm.deactivate_instagram_account, pm.request_area_id, pm.requester_id, pm.board_id, pm.adms_sits_personnel_mov_id, pm.observation, ca.nome office_name, df.uniform, df.phone_chip, df.original_card, df.signature_date_trct, df.aso_resigns, df.send_aso_guide, sd.name status, cr.cor, pm.created, pm.modified FROM adms_personnel_moviments pm LEFT JOIN tb_lojas lj ON lj.id = pm.adms_loja_id LEFT JOIN tb_funcionarios fc ON fc.id = pm.adms_employee_id LEFT JOIN tb_cargos ca ON ca.id = fc.cargo_id LEFT JOIN adms_dismissal_follow_up df ON df.adms_person_mov_id = pm.id LEFT JOIN adms_sits_personnel_moviments sd ON sd.id = pm.adms_sits_personnel_mov_id LEFT JOIN adms_cors cr ON cr.id = sd.adms_cor_id WHERE pm.id =:id LIMIT :limit", "id={$this->DadosId}&limit=1");
        } else {
            $viewMoviment->fullRead("SELECT pm.id, pm.adms_loja_id, lj.nome store, pm.adms_area_id, pm.adms_employee_id, fc.nome colaborador, pm.last_day_worked, pm.adms_employee_relation_id, pm.adms_resignation_id, pm.early_warning_id, pm.fouls, pm.days_off, pm.folds, pm.fixed_fund, pm.access_power_bi, pm.access_zznet, pm.access_cigam, pm.access_camera, pm.access_deskfy, pm.access_meu_atendimento, pm.access_dito, pm.notebook, pm.email_corporate, pm.office_parking_card, pm.office_parking_shopping, pm.key_office, pm.key_store, pm.instagram_corporate, pm.deactivate_instagram_account, pm.request_area_id, pm.requester_id, pm.board_id, pm.adms_sits_personnel_mov_id, pm.observation, ca.nome office_name, df.uniform, df.phone_chip, df.original_card, df.signature_date_trct, df.aso_resigns, df.send_aso_guide, sd.name status, cr.cor, pm.created, pm.modified FROM adms_personnel_moviments pm LEFT JOIN tb_lojas lj ON lj.id = pm.adms_loja_id LEFT JOIN tb_funcionarios fc ON fc.id = pm.adms_employee_id LEFT JOIN tb_cargos ca ON ca.id = fc.cargo_id LEFT JOIN adms_dismissal_follow_up df ON df.adms_person_mov_id = pm.id LEFT JOIN adms_sits_personnel_moviments sd ON sd.id = pm.adms_sits_personnel_mov_id LEFT JOIN adms_cors cr ON cr.id = sd.adms_cor_id WHERE pm.id =:id AND pm.adms_loja_id =:adms_loja_id AND pm.adms_sits_personnel_mov_id <=:adms_sits_personnel_mov_id LIMIT :limit", "id={$this->DadosId}&adms_loja_id=" . $_SESSION['usuario_loja'] . "&adms_sits_personnel_mov_id=2&limit=1");
        }
        $this->Resultado = $viewMoviment->getResult();
        return $this->Resultado;
    }

    public function altOrder(array $Dados) {
        $this->Dados = $Dados;
        $this->File = $this->Dados['file_name'];
        $this->Observation = $this->Dados['observation'];

        unset($this->Dados['delete'], $this->Dados['file_name'], $this->Dados['observation']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazioComTag();
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->treatData($this->Dados);
        } else {
            $this->Resultado = false;
        }
    }

    private function treatDismissalData() {
        $this->DismissalFollow = $this->Dados;
        var_dump($this->DismissalFollow);
        unset($this->Dados['uniform'], $this->Dados['aso'], $this->Dados['aso_resigns'], $this->Dados['send_aso_guide']);
        $this->updateEditPersonnelMoviments();
    }

    private function treatData(array $Dados) {
        //var_dump($Dados);
        $this->Optional = $Dados;

        $this->Optional['adms_area_id'] = (isset($this->Dados['request_area_id']) and !empty($this->Dados['request_area_id'])) ? $this->Dados['request_area_id'] : 0;
        $this->Optional['fouls'] = (isset($this->Dados['totalFouls']) and !empty($this->Dados['totalFouls'])) ? $this->Dados['totalFouls'] : 0;
        $this->Optional['days_off'] = (isset($this->Dados['totalDaysOff']) and !empty($this->Dados['totalDaysOff'])) ? $this->Dados['totalDaysOff'] : null;
        $this->Optional['folds'] = (isset($this->Dados['totalFolds']) and !empty($this->Dados['totalFolds'])) ? date("H:i:s", strtotime($this->Dados['totalFolds'])) : null;
        $this->Optional['totalFund'] = (isset($this->Dados['totalFund']) and !empty($this->Dados['totalFund'])) ? str_replace(".", "", $this->Dados['totalFund']) : null;
        $this->Optional['fixed_fund'] = (isset($this->Optional['totalFund']) and !empty($this->Optional['totalFund'])) ? str_replace(",", ".", $this->Optional['totalFund']) : null;

        unset($this->Dados['totalFouls'], $this->Dados['totalDaysOff'], $this->Dados['totalFolds'], $this->Dados['totalFund']);

        var_dump($this->Optional);
        if (!empty($this->File['name'][0])) {
            $this->valArquivo();
        } else {
            $this->treatDismissalData();
        }
    }

    private function valArquivo() {
        if (!isset($this->File['name'][0]) || empty($this->File['name'][0])) {
            $this->treatDismissalData();
        }

        $uploadPath = 'assets/files/mp/' . $_SESSION['id'] . '/';
        $arquivosParaUpload = [];

        foreach ($this->File['name'] as $key => $filename) {
            $arquivosParaUpload[] = [
                'tmp_name' => $this->File['tmp_name'][$key],
                'name' => $filename,
                'type' => $this->File['type'][$key],
                'error' => $this->File['error'][$key],
                'size' => $this->File['size'][$key]
            ];
        }

        if (count($arquivosParaUpload) > 1) {
            $uploadFile = new \App\adms\Models\helper\AdmsUploadMultFiles();
            $uploadFile->upload($uploadPath, $arquivosParaUpload);
        } else {
            $newName = new \App\adms\Models\helper\AdmsSlug();
            $this->File['name'][0] = $newName->nomeSlug($this->File['name'][0]);

            $uploadFile = new \App\adms\Models\helper\AdmsUpload();
            $uploadFile->upload($arquivosParaUpload[0], $uploadPath, $this->File['name'][0]);
        }

        if ($uploadFile->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>MP</strong> atualizada com sucesso. Upload do arquivo realizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>MP:</strong> Satualizada com sucesso. Upload do arquivo realizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    private function updateEditPersonnelMoviments() {

        $this->Dados['observation'] = !empty($this->Observation) ? $this->Observation : null;
        $this->Dados['fouls'] = !empty($this->Optional['fouls']) ? $this->Optional['fouls'] : null;
        $this->Dados['days_off'] = !empty($this->Optional['days_off']) ? $this->Optional['days_off'] : null;
        $this->Dados['folds'] = !empty($this->Optional['folds']) ? $this->Optional['folds'] : null;
        $this->Dados['fixed_fund'] = !empty($this->Optional['fixed_fund']) ? $this->Optional['fixed_fund'] : null;
        $this->Dados['updated_by'] = $_SESSION['usuario_id'];
        $this->Dados['modified'] = date("Y-m-d H:i:s");

        $upAltOrder = new \App\adms\Models\helper\AdmsUpdate();
        $upAltOrder->exeUpdate("adms_personnel_moviments", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltOrder->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>MP</strong> atualizada com sucesso. Upload do arquivo realizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> A MP não foi atualizada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    public function listAdd() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id s_id, name status FROM adms_sits_personnel_moviments ORDER BY id ASC");
        $registro['status'] = $listar->getResult();

        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $listar->fullRead("SELECT id s_id, nome store FROM tb_lojas WHERE id =:id AND status_id =:status_id ORDER BY id ASC", "id=" . $_SESSION['usuario_loja'] . "&status_id=1");
        } else {
            $listar->fullRead("SELECT id s_id, nome store FROM tb_lojas WHERE status_id =:status_id ORDER BY id ASC", "status_id=1");
        }
        $registro['store'] = $listar->getResult();

        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $listar->fullRead("SELECT id f_id, nome colaborador FROM tb_funcionarios WHERE loja_id =:loja_id AND status_id =:status_id ORDER BY nome ASC", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id=1");
        } else {//$_SESSION['area_id']
            $listar->fullRead("SELECT id f_id, nome colaborador FROM tb_funcionarios WHERE status_id =:status_id ORDER BY nome ASC", "status_id=1");
        }
        $registro['employee'] = $listar->getResult();

        if ($_SESSION['adms_niveis_acesso_id'] == STOREPERMITION) {
            $listar->fullRead("SELECT id a_id, name area_name FROM adms_areas WHERE id =:id AND status_id =:status_id ORDER BY name ASC", "loja_id=" . $_SESSION['usuario_loja'] . "&status_id=1");
        } else {//$_SESSION['area_id']
            $listar->fullRead("SELECT id a_id, name area_name FROM adms_areas WHERE status_id =:status_id ORDER BY name ASC", "status_id=1");
        }
        $registro['area'] = $listar->getResult();

        $listar->fullRead("SELECT id m_id, name manager FROM adms_managers WHERE status_id =:status_id ORDER BY name ASC ", "status_id=1");
        $registro['manager'] = $listar->getResult();

        $listar->fullRead("SELECT f.id f_id, f.nome manager_sector FROM tb_funcionarios f LEFT JOIN tb_cargos c ON c.id = f.cargo_id LEFT JOIN adms_niv_cargos nv ON nv.id = c.adms_niv_cargo_id WHERE c.adms_niv_cargo_id =:adms_niv_cargo_id AND f.status_id =:status_id ORDER BY f.nome", "adms_niv_cargo_id=1&status_id=1");
        $registro['manager_sector'] = $listar->getResult();

        $this->Resultado = ['store' => $registro['store'], 'employee' => $registro['employee'], 'area' => $registro['area'], 'manager' => $registro['manager'], 'manager_sector' => $registro['manager_sector'], 'status' => $registro['status']];

        return $this->Resultado;
    }
}
