<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsApagarBandeira
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsApagarBandeira {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarBandeira($DadosId = null) {
        
        $this->DadosId = (int) $DadosId;
        
        $apagarBandeira = new \App\adms\Models\helper\AdmsDelete();
        $apagarBandeira->exeDelete("adms_bandeiras", "WHERE id =:id", "id={$this->DadosId}");
        
        if ($apagarBandeira->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Bandeira apagada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A bandeira não foi apagada!</div>";
            $this->Resultado = false;
        }
    }

}
