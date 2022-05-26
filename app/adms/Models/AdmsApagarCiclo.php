<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsApagarCiclo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsApagarCiclo {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarCiclo($DadosId = null) {
        
        $this->DadosId = (int) $DadosId;
        
        $apagarCiclo = new \App\adms\Models\helper\AdmsDelete();
        $apagarCiclo->exeDelete("adms_ciclos", "WHERE id =:id", "id={$this->DadosId}");
        
        if ($apagarCiclo->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Cadastro</strong> apagado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'><strong>Erro:</strong> Registro não apagado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $this->Resultado = false;
        }
    }

}
