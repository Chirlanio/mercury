<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsDeleteVacancyOpening
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsDeleteVacancyOpening {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function deleteVacancy($DadosId = null) {
        
        $this->DadosId = (int) $DadosId;
        
        $delBrand = new \App\adms\Models\helper\AdmsDelete();
        $delBrand->exeDelete("adms_vacancy_opening", "WHERE id =:id AND adms_sit_vacancy_id =:adms_sit_vacancy_id", "id={$this->DadosId}&adms_sit_vacancy_id=1");
        
        if ($delBrand->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Abertura de vaga</strong> apagada com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> O registro não foi apagado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

}
