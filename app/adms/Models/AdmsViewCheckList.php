<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsViewCheckList
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsViewCheckList {

    private $Resultado;
    private $DadosId;
    private string|null $Questions;

    /**
     * <b>View Check List:</b> Receber o id do check list para buscar informações do registro no banco de dados
     * @param int $DadosId
     */
    public function viewCheckList(string $DadosId) {
        $this->DadosId = $DadosId;
        $viewCheckList = new \App\adms\Models\helper\AdmsRead();
        $viewCheckList->fullRead("SELECT cls.id cls_id, cls.hash_id, cls.adms_store_id, lj.nome stores, cls.justified, cls.action_plans, cls.adms_check_list_area_id, cla.id cla_id, cla.name name_area, cla.weigth, cla.order_area, cls.adms_check_list_question_id, clq.id clq_id, clq.order_question, clq.question_description, clq.points, clq.weight_question, cls.adms_sits_question_id, clsq.name_sit, c.cor, f.nome responsible, cls.initial_date, cls.final_date FROM adms_check_list_stores cls LEFT JOIN tb_lojas lj ON lj.id = cls.adms_store_id LEFT JOIN adms_check_list_areas cla ON cla.id = cls.adms_check_list_area_id LEFT JOIN adms_check_list_questions clq ON clq.id = cls.adms_check_list_question_id LEFT JOIN adms_sit_check_list_questions clsq ON clsq.id = cls.adms_sits_question_id LEFT JOIN adms_cors c ON c.id = clsq.adms_cor_id LEFT JOIN tb_funcionarios f ON f.id = cls.responsible_id WHERE cls.hash_id =:hash", "hash=" . $this->DadosId);
        $this->Resultado = $viewCheckList->getResult();
        //var_dump($viewCheckList);
        return $this->Resultado;
    }

    public function listAdd(string|null $DadosId = null) {
        
        $this->DadosId = $DadosId;
        $list = new \App\adms\Models\helper\AdmsRead();

        $list->fullRead("SELECT COUNT(id) resp_result FROM adms_check_list_stores WHERE hash_id =:hash AND adms_sits_question_id <>:sits", "hash={$this->DadosId}&sits=1");
        $register['countHashResp'] = $list->getResult();

        $list->fullRead("SELECT COUNT(id) no_resp_result FROM adms_check_list_stores WHERE hash_id =:hash AND adms_sits_question_id =:sits", "hash={$this->DadosId}&sits=1");
        $register['countHashNoResp'] = $list->getResult();

        $list->fullRead("SELECT id cslq_id, name_sit FROM adms_sit_check_list_questions");
        $register['responseQuests'] = $list->getResult();

        $list->fullRead("SELECT id id_cla, name name_area FROM adms_check_list_areas WHERE adms_sit_id =:sit", "sit=1");
        $register['areas'] = $list->getResult();

        $list->fullRead("SELECT id clq_id, adms_check_list_area_id clqa_id, question_description FROM adms_check_list_questions WHERE adms_sit_id =:sitq", "sitq=1");
        $register['questions'] = $list->getResult();

        return $this->Resultado = ['countHashResp' => $register['countHashResp'], 'countHashNoResp' => $register['countHashNoResp'],
            'areas' => $register['areas'], 'questions' => $register['questions'],
            'responseQuests' => $register['responseQuests']];
    }
    
    public function totalQuestions(string|null $Questions = null) {
        
        $this->Questions = $Questions;
        $totalQuestions = new \App\adms\Models\helper\AdmsRead();
        
        $totalQuestions->fullRead("SELECT SUM(points) AS totalPoints FROM adms_check_list_questions WHERE adms_sit_id =:sits", "sits=1");
        $register['totalPoints'] = $totalQuestions->getResult();
        
        $totalQuestions->fullRead("SELECT SUM(points) AS totalPointsReceived FROM adms_check_list_stores WHERE hash_id =:hash", "hash={$this->Questions}");
        $register['totalPontuation'] = $totalQuestions->getResult();
        
        $totalQuestions->fullRead("SELECT ROUND((SUM(s.points) / SUM(q.points)) * 100, 2) AS num_result FROM adms_check_list_questions q JOIN adms_check_list_stores s ON s.adms_check_list_question_id = q.id WHERE s.hash_id =:hash", "hash={$this->Questions}");
        $register['totalPercent'] = $totalQuestions->getResult();
        
        $totalQuestions->fullRead("SELECT a.name area_name, ROUND((SUM(s.points) / SUM(q.points)) * 100, 2) AS num_result FROM adms_check_list_questions q JOIN adms_check_list_stores s ON s.adms_check_list_question_id = q.id LEFT JOIN adms_check_list_areas a ON a.id = q.adms_check_list_area_id WHERE s.hash_id =:hash GROUP BY q.adms_check_list_area_id", "hash={$this->Questions}");
        $register['totalArea'] = $totalQuestions->getResult();
        
        return $this->Resultado = ['totalPoints' => $register['totalPoints'], 'totalPontuation' => $register['totalPontuation'], 'totalPercent' => $register['totalPercent'], 'totalArea' => $register['totalArea']];
    }
}
