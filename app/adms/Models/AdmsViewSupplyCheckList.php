<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsViewSupplyCheckList
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsViewSupplyCheckList {

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
        $viewCheckList->fullRead("SELECT cls.id cls_id, cls.hash_id, cls.adms_store_id, cls.adms_supply_check_list_question_id, cls.adms_supply_check_list_area_id, cls.justified, cls.action_plans, cls.adms_supply_sits_question_id, cls.initial_date, cls.final_date, cla.id cla_id, cla.name name_area, cla.order_area, clq.id clq_id, clq.order_question, clq.question_description, lj.nome stores, clsq.name_sit, c.cor, f.nome responsible FROM adms_supply_check_list_stores cls LEFT JOIN tb_lojas lj ON lj.id = cls.adms_store_id LEFT JOIN adms_supply_check_list_areas cla ON cla.id = cls.adms_supply_check_list_area_id LEFT JOIN adms_supply_check_list_questions clq ON clq.id = cls.adms_supply_check_list_question_id LEFT JOIN adms_supply_sit_check_list_questions clsq ON clsq.id = cls.adms_supply_sits_question_id LEFT JOIN adms_cors c ON c.id = clsq.adms_cor_id LEFT JOIN tb_funcionarios f ON f.id = cls.action_plan_responsible_id WHERE cls.hash_id =:hash", "hash=" . $this->DadosId);
        $this->Resultado = $viewCheckList->getResult();
        //var_dump($viewCheckList);
        return $this->Resultado;
    }

    public function listAdd(string|null $DadosId = null) {
        
        $this->DadosId = $DadosId;
        $list = new \App\adms\Models\helper\AdmsRead();

        $list->fullRead("SELECT COUNT(id) resp_result FROM adms_supply_check_list_stores WHERE hash_id =:hash AND adms_supply_sits_question_id <>:sits", "hash={$this->DadosId}&sits=1");
        $register['countHashResp'] = $list->getResult();

        $list->fullRead("SELECT COUNT(id) no_resp_result FROM adms_supply_check_list_stores WHERE hash_id =:hash AND adms_supply_sits_question_id =:sits", "hash={$this->DadosId}&sits=1");
        $register['countHashNoResp'] = $list->getResult();

        $list->fullRead("SELECT id cslq_id, name_sit FROM adms_supply_sit_check_list_questions");
        $register['responseQuests'] = $list->getResult();

        $list->fullRead("SELECT id id_cla, name name_area FROM adms_supply_check_list_areas WHERE adms_sit_id =:sit", "sit=1");
        $register['areas'] = $list->getResult();

        $list->fullRead("SELECT id clq_id, adms_check_list_area_id clqa_id, question_description FROM adms_supply_check_list_questions WHERE adms_sit_id =:sitq", "sitq=1");
        $register['questions'] = $list->getResult();

        return $this->Resultado = ['countHashResp' => $register['countHashResp'], 'countHashNoResp' => $register['countHashNoResp'],
            'areas' => $register['areas'], 'questions' => $register['questions'],
            'responseQuests' => $register['responseQuests']];
    }
    
    public function totalQuestions(string|null $Questions = null) {
        
        $this->Questions = $Questions;
        $totalQuestions = new \App\adms\Models\helper\AdmsRead();
        
        $totalQuestions->fullRead("SELECT COUNT(id) AS totalPoints FROM adms_supply_check_list_stores WHERE hash_id =:hash AND adms_supply_sit_check_list_id =:sits", "hash={$this->Questions}&sits=1");
        $register['totalPoints'] = $totalQuestions->getResult();
        
        $totalQuestions->fullRead("SELECT COUNT(id) AS totalPointsReceived FROM adms_supply_check_list_stores WHERE hash_id =:hash AND adms_supply_check_list_question_id =:sits", "hash={$this->Questions}&sits=2");
        $register['totalPontuation'] = $totalQuestions->getResult();
        
        $totalQuestions->fullRead("SELECT ROUND((COUNT(id) / (SELECT COUNT(id) FROM adms_supply_check_list_questions WHERE adms_sit_id = 1)) * 100.0, 2) AS num_result FROM adms_supply_check_list_stores WHERE hash_id =:hash AND adms_supply_sits_question_id =:sits;", "hash={$this->Questions}&sits=2");
        $register['totalPercent'] = $totalQuestions->getResult();
        
        $totalQuestions->fullRead("SELECT a.name area_name, ROUND((SUM(s.points) / SUM(q.points)) * 100.0, 2) AS num_result FROM adms_supply_check_list_questions q LEFT JOIN adms_supply_check_list_stores s ON s.adms_supply_check_list_question_id = q.id LEFT JOIN adms_supply_check_list_areas a ON a.id = q.adms_supply_check_list_area_id WHERE s.hash_id =:hash GROUP BY q.adms_supply_check_list_area_id", "hash={$this->Questions}");
        $register['totalArea'] = $totalQuestions->getResult();
        
        return $this->Resultado = ['totalPoints' => $register['totalPoints'], 'totalPontuation' => $register['totalPontuation'], 'totalPercent' => $register['totalPercent'], 'totalArea' => $register['totalArea']];
    }
}
