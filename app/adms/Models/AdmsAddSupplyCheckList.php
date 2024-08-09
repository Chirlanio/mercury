<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsAddSupplyCheckList
 *
 * @copyright (c) year, Francisco Chirlanio - Grupo Meioa Sola
 */
class AdmsAddSupplyCheckList {

    private $Resultado;
    private $Dados;
    private $Questions;
    private array|object|null $CheckList;
    private array|object|null $CheckListStore;
    private $Responsible;

    function getResultado() {
        return $this->Resultado;
    }

    public function addCheckList(array $Dados) {

        $this->Dados = $Dados;

        //var_dump($this->Dados);
        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazioComTag;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->insertCheckList();
        } else {
            $this->Resultado = false;
        }
    }

    private function insertCheckList() {

        $this->Dados['hash_id'] = hash("md5", date("Y-m-d H:i:s"));
        $this->Dados['adms_sit_check_list_id'] = 1;
        $this->Dados['created'] = date("Y-m-d H:i:s");

        //var_dump($this->Dados);
        $addCheckList = new \App\adms\Models\helper\AdmsCreate();
        $addCheckList->exeCreate("adms_supply_check_lists", $this->Dados);

        if ($addCheckList->getResult()) {
            $this->Dados['id'] = $addCheckList->getResult();
            $this->viewAllQuestions();
            //$this->insertCheckListStore($this->Dados);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> A solicitação não foi cadastrada!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

    private function viewAllQuestions() {

        $viewQuestions = new \App\adms\Models\helper\AdmsRead();
        $viewQuestions->fullRead("SELECT ca.id AS ca_id, cq.id AS cq_id
                FROM adms_supply_check_list_areas AS ca
                LEFT JOIN adms_supply_check_list_questions AS cq ON ca.id = cq.adms_supply_check_list_area_id
                WHERE ca.adms_sit_id =:sit_id OR cq.adms_sit_id =:question", "sit_id=1&question=1");
        $this->Questions = $viewQuestions->getResult();

        if ($viewQuestions->getResult()) {
            $this->viewResponsible($this->Dados['adms_store_id']);
            $this->insertCheckListStore($this->Dados);
        }
    }

    private function viewResponsible(string|null $StoreId) {
        $this->Responsible = $StoreId;

        $responsible = new \App\adms\Models\helper\AdmsRead();
        $responsible->fullRead("SELECT * FROM tb_lojas WHERE id =:store", "store={$this->Responsible}");
        $this->Responsible = $responsible->getResult();
    }

    private function insertCheckListStore(array|object|null $Data): bool {

        $this->CheckList = $Data;

        foreach ($this->Questions as $question) {

            $this->CheckListStore['adms_supply_check_list_id'] = (int) $this->CheckList['id'];
            $this->CheckListStore['hash_id'] = $this->CheckList['hash_id'];
            $this->CheckListStore['adms_store_id'] = $this->CheckList['adms_store_id'];
            $this->CheckListStore['adms_supply_check_list_area_id'] = $question['ca_id'];
            $this->CheckListStore['adms_supply_check_list_question_id'] = $question['cq_id'];
            $this->CheckListStore['adms_supply_sits_question_id'] = 1;
            $this->CheckListStore['responsible_id'] = (int) $this->Responsible[0]['func_id'];
            $this->CheckListStore['responsible_applicator'] = (int) $this->CheckList['responsible_applicator'];
            $this->CheckListStore['adms_supply_sit_check_list_id'] = 1;
            $this->CheckListStore['created'] = date("Y-m-d H:i:s");

            $checkListStore = new \App\adms\Models\helper\AdmsCreate();
            $checkListStore->exeCreate("adms_supply_check_list_stores", $this->CheckListStore);

            if ($checkListStore->getResult()) {
                $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Check List</strong> cadastrado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                //return $this->Resultado = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Check List não cadastrado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                //return $this->Resultado = false;
            }
        }

        return $this->Resultado = true;
    }

    public function lastId() {
        $lastid = new \App\adms\Models\helper\AdmsRead();
        $lastid->fullRead("SELECT id FROM adms_supply_check_lists ORDER BY id DESC LIMIT :limit", "limit=1");
        $this->Resultado = $lastid->getResult();
        return $this->Resultado;
    }

    public function listAdd() {
        $listar = new \App\adms\Models\helper\AdmsRead();

        $listar->fullRead("SELECT id f_id, nome applicator_name FROM tb_funcionarios WHERE loja_id =:store AND status_id =:sit ORDER BY nome ASC", "store=Z443&sit=1");
        $registro['applicators'] = $listar->getResult();

        $listar->fullRead("SELECT id l_id, nome name_store FROM tb_lojas WHERE status_id =:status_id ORDER BY id ASC", "status_id=1");
        $registro['stores'] = $listar->getResult();

        $this->Resultado = ['stores' => $registro['stores'], 'applicators' => $registro['applicators']];

        return $this->Resultado;
    }
}
