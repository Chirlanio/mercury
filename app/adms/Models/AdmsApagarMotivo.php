<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsApagarMotivo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsApagarMotivo {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarMotivo($DadosId = null) {
        
        $this->DadosId = (int) $DadosId;
        
        $apagarMotivo = new \App\adms\Models\helper\AdmsDelete();
        $apagarMotivo->exeDelete("adms_motivo_estorno", "WHERE id =:id", "id={$this->DadosId}");
        
        if ($apagarMotivo->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Motivo de estorno apagado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O Motivo de estorno não foi apagado!</div>";
            $this->Resultado = false;
        }
    }

}
