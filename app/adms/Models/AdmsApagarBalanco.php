<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsApagarBalanco
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsApagarBalanco {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarBalanco($DadosId = null) {
        $this->DadosId = (int) $DadosId;

        $apagarBalanco = new \App\adms\Models\helper\AdmsDelete();
        $apagarBalanco->exeDelete("adms_balancos", "WHERE id =:id", "id={$this->DadosId}");
        if ($apagarBalanco->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Solicitação apagado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A Solicitação não foi apagado!</div>";
            $this->Resultado = false;
        }
    }

}
