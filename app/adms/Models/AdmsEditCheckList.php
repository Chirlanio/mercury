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

    function getResultado() {
        return $this->Resultado;
    }

    public function viewCheckList($DadosId) {

        $this->DadosId = (string) $DadosId;
        $_SESSION['id'] = $this->DadosId;

        $viewCheckList = new \App\adms\Models\helper\AdmsRead();
        $viewCheckList->fullRead("SELECT cls.id as cls_id, cls.hash_id, cls.adms_store_id, cla.id as cla_id, cla.name AS area,
                clq.id as clq_id, clq.adms_check_list_area_id as clqa_id, clq.question_description
                FROM adms_check_list_stores AS cls
                LEFT JOIN adms_check_list_areas AS cla ON cls.adms_check_list_area_id = cla.id
                LEFT JOIN adms_check_list_questions AS clq ON cls.adms_check_list_question_id = clq.id
                WHERE cls.hash_id =:hash", "hash={$this->DadosId}");
        $this->Resultado = $viewCheckList->getResult();
        return $this->Resultado;
    }

    public function altCheckList(array $Dados) {
        $this->Dados = $Dados;

        $this->File = (!empty($this->Dados['new_files']['name'])) ? $this->Dados['new_files'] : $this->Dados['file_name'];

        unset($this->Dados['new_files'], $this->Dados['file_name']);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazioComTag();
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            if (!empty($this->File['name'][0])) {
                $this->validationFiles();
            } else {
                $this->updateEditOrderPayment();
            }
        } else {
            $this->Resultado = false;
        }
    }

    private function validationFiles() {
        if (!isset($this->File['name'][0])) {
            $this->updateEditCheckList();
        }

        $uploadPath = 'assets/files/checkListComertial/' . $_SESSION['id'] . '/' . $this->Dados['id'];
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
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Ordem de pagamento:</strong> Solicitação atualizada com sucesso. Upload do arquivo realizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Ordem de pagamento:</strong> Solicitação atualizada com sucesso. Upload do arquivo realizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    private function updateEditCheckList() {

        if (!empty($this->File['name'][0])) {
            $slugImg = new \App\adms\Models\helper\AdmsSlug();
            $this->Dados['file_name'] = $slugImg->nomeSlug($this->File['name'][0]);
        }
        $this->Dados['modified'] = date("Y-m-d H:i:s");

        $upAltOrder = new \App\adms\Models\helper\AdmsUpdate();
        $upAltOrder->exeUpdate("adms_order_payments", $this->Dados, "WHERE id =:id", "id=" . $_SESSION['id']);
        if ($upAltOrder->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Ordem de pagamento</strong> atualizada com sucesso. Upload do arquivo realizado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->updateInstallment();
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> A ordem de pagamento não foi atualizada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
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

        $this->Resultado = ['sits' => $registro['sits'], 'areas' => $registro['areas'], 'questions' => $registro['questions']];

        return $this->Resultado;
    }
}
