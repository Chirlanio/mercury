<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsApagarBairro
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsDelCostCenter {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function delCostCenter($DadosId = null) {
        
        $this->DadosId = (int) $DadosId;
        
        $delCostCenter = new \App\adms\Models\helper\AdmsDelete();
        $delCostCenter->exeDelete("adms_cost_centers", "WHERE id =:id", "id={$this->DadosId}");
        
        if ($delCostCenter->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Centro de custo</strong>  apagado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Erro:</strong> Centro de custos não apagado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

}
