<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditCheckList
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meia Sola
 */
class AdmsEditCheckList {

    private $Resultado;
    private $Dados;
    private $DadosId;
    private $File;
    private $EmptyField;
    private $CheckList;

    function getResultado() {
        return $this->Resultado;
    }

    public function viewCheckList($DadosId) {

        $this->DadosId = (string) $DadosId;
        $_SESSION['id'] = $this->DadosId;

        $viewCheckList = new \App\adms\Models\helper\AdmsRead();
        $viewCheckList->fullRead("SELECT cls.id as cls_id, cls.hash_id, cls.adms_store_id, cls.adms_sits_question_id, cla.id as cla_id, cla.name AS name_area, clq.id as clq_id, clq.adms_check_list_area_id as clqa_id, clq.question_description FROM adms_check_list_stores AS cls LEFT JOIN adms_check_list_areas AS cla ON cls.adms_check_list_area_id = cla.id LEFT JOIN adms_check_list_questions AS clq ON cls.adms_check_list_question_id = clq.id WHERE cls.hash_id =:hash AND cls.adms_sits_question_id =:sit_id LIMIT :limit", "hash={$this->DadosId}&sit_id=1&limit=1");
        $this->Resultado = $viewCheckList->getResult();
        $_SESSION['adms_store_id'] = $this->Resultado[0]['adms_store_id'];
        return $this->Resultado;
    }

    public function altCheckList(array $Dados) {
        $this->Dados = $Dados;

        $this->EmptyField['adms_sits_question_id'] = $this->Dados['adms_sits_question_id'];

        $this->File = $this->Dados['file_name'];
        $this->EmptyField['justified'] = !empty($this->Dados['justified']) ? strip_tags($this->Dados['justified']) : null;
        $this->EmptyField['action_plans'] = !empty($this->Dados['action_plans']) ? strip_tags($this->Dados['action_plans']) : null;
        $this->EmptyField['initial_date'] = !empty($this->Dados['initial_date']) ? strip_tags($this->Dados['initial_date']) : null;
        $this->EmptyField['final_date'] = !empty($this->Dados['final_date']) ? strip_tags($this->Dados['final_date']) : null;
        $this->EmptyField['action_plan_responsible_id'] = !empty($this->Dados['action_plan_responsible_id']) ? strip_tags($this->Dados['action_plan_responsible_id']) : null;

        unset($this->Dados['file_name'], $this->Dados['justified'], $this->Dados['action_plans'], $this->Dados['initial_date'], $this->Dados['final_date'], $this->Dados['action_plan_responsible_id']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazioComTag();
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            if (!empty($this->File['name'][0])) {
                $this->validationFiles();
            } else {
                $this->updateEditCheckList();
            }
        } else {
            $this->Resultado = false;
        }
    }

    private function validationFiles() {
        if (!isset($this->File['name'][0])) {
            $this->updateEditCheckList();
        }

        $uploadPath = 'assets/imagens/commercial/checkList/' . $_SESSION['id'] . '/' . $this->Dados['id'] . '/';
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
            $uploadFile = new \App\adms\Models\helper\AdmsUploadMultImages();
            $uploadFile->upload($uploadPath, $arquivosParaUpload);
        } else {
            $newName = new \App\adms\Models\helper\AdmsSlug();
            $this->File['name'][0] = $newName->nomeSlug($this->File['name'][0]);

            $uploadFile = new \App\adms\Models\helper\AdmsUpload();
            $uploadFile->upload($arquivosParaUpload[0], $uploadPath, $this->File['name'][0]);
        }

        if ($uploadFile->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Check List:</strong> Resposta salva com sucesso, Upload. Arquivo salvo com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->updateEditCheckList();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Check List:</strong> Resposta salva com sucesso. Arquivo salvo com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    private function updateEditCheckList() {

        $this->Dados['action_plans'] = $this->EmptyField['action_plans'];
        $this->Dados['initial_date'] = $this->EmptyField['initial_date'];
        $this->Dados['final_date'] = $this->EmptyField['final_date'];
        $this->Dados['action_plan_responsible_id'] = $this->EmptyField['action_plan_responsible_id'];
        $this->Dados['evaluation_date'] = date("Y-m-d");
        $this->Dados['points'] = $this->Dados['adms_sits_question_id'] == 1 ? 1 : ($this->Dados['adms_sits_question_id'] == 2 ? 0.5 : 0);
        $this->Dados['justified'] = $this->EmptyField['justified'];
        $this->Dados['modified'] = date("Y-m-d H:i:s");

        $upAltOrder = new \App\adms\Models\helper\AdmsUpdate();
        $upAltOrder->exeUpdate("adms_check_list_stores", $this->Dados, "WHERE id =:id AND hash_id =:hash", "id=" . $this->Dados['id'] . "&hash={$this->Dados['hash_id']}");
        if ($upAltOrder->getResult()) {
            $this->altSitCheckList();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Ao tentar salvar resposta, arquivo não enviado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    private function altSitCheckList() {
        $this->CheckList['hash_id'] = $this->Dados['hash_id'];
        $this->CheckList['modified'] = date('Y-m-d H:i:s');

        $updataCheckList = new \App\adms\Models\helper\AdmsRead();
        $updataCheckList->fullRead("SELECT COUNT(id) as resp_result FROM adms_check_list_stores WHERE hash_id =:hash AND adms_sits_question_id <>:sit_id", "hash={$_SESSION['id']}&sit_id=1");
        $num_result = $updataCheckList->getResult();

        if ($num_result[0]['resp_result'] == 1) {
            $this->CheckList['adms_sit_check_list_id'] = 2;
        }

        if ($updataCheckList->getResult() == 28) {
            $this->CheckList['adms_sit_check_list_id'] = 3;
        }

        $updateCheckList = new \App\adms\Models\helper\AdmsUpdate();
        $updateCheckList->exeUpdate('adms_check_lists', $this->CheckList, "WHERE hash_id =:hash", "hash={$this->CheckList['hash_id']}");
        $this->Resultado = $updateCheckList->getResult();

        if ($this->Resultado) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Check List</strong> salvo com sucesso. Arquivo enviado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            //$this->Resultado = true;
            return $this->Resultado = true;
        }
    }

    public function listAdd() {

        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead("SELECT id st_id, exibition_name sit FROM adms_sits_order_payments WHERE status_id =:status_id ORDER BY id ASC", "status_id=1");
        $registro['sits'] = $listar->getResult();

        $listar->fullRead("SELECT id cla_id, name name_area FROM adms_check_list_areas WHERE adms_sit_id =:sit", "sit=1");
        $registro['areas'] = $listar->getResult();

        $listar->fullRead("SELECT id clq_id, adms_check_list_area_id clqa_id, question_description FROM adms_check_list_questions WHERE adms_sit_id =:sitq", "sitq=1");
        $registro['questions'] = $listar->getResult();

        $listar->fullRead("SELECT COUNT(id) as resp_result FROM adms_check_list_stores WHERE hash_id =:hash AND adms_sits_question_id <>:sit_id", "hash={$_SESSION['id']}&sit_id=1");
        $registro['countHashResp'] = $listar->getResult();

        $listar->fullRead("SELECT COUNT(id) as no_resp_result FROM adms_check_list_stores WHERE hash_id =:hash AND adms_sits_question_id =:sit_id", "hash={$_SESSION['id']}&sit_id=1");
        $registro['countHashNoResp'] = $listar->getResult();

        $listar->fullRead("SELECT id s_id, nome resp_store FROM tb_funcionarios WHERE loja_id =:store AND status_id =:sit", "store={$_SESSION['adms_store_id']}&sit=1");
        $registro['responsibles'] = $listar->getResult();

        $this->Resultado = ['sits' => $registro['sits'], 'areas' => $registro['areas'], 'questions' => $registro['questions'], 'countHashResp' => $registro['countHashResp'], 'countHashNoResp' => $registro['countHashNoResp'], 'responsibles' => $registro['responsibles']];

        return $this->Resultado;
    }
}
