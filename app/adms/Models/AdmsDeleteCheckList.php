<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsDeleteCheckList
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsDeleteCheckList {

    private string|null $DadosId;
    private int|string|null $QuestionId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function deleteCheckList(string|null $DadosId = null) {
        $this->DadosId = $DadosId;

        $delCheckList = new \App\adms\Models\helper\AdmsDelete();
        $delCheckList->exeDelete("adms_check_lists", "WHERE hash_id =:hash AND adms_sit_check_list_id =:sit_check_list", "hash={$this->DadosId}&sit_check_list=1");

        if ($delCheckList->getResult()) {
            $this->delQuestions($this->DadosId);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Só é permitido apagar Check Lists com a situação \"Pendente\"!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }
    
    private function delQuestions(int|string|null $QuestionId) {
        $this->QuestionId = $QuestionId;
        
        $delQuestions = new \App\adms\Models\helper\AdmsDelete();
        $delQuestions->exeDelete('adms_check_list_stores', "WHERE hash_id =:hash", "hash={$this->QuestionId}");
        
        if($delQuestions->getResult()){
            $delFiles = new \App\adms\Models\helper\AdmsApagarArq();
            $delFiles->apagarArq('assets/imagens/commercial/checkList/' . $this->DadosId, 'assets/imagens/commercial/checkList/' . $this->DadosId);
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Check List</strong> e arquivos apagados com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        }
    }
}
