<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsApagarResp
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsApagarResp {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarResp($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $apagarCargo = new \App\adms\Models\helper\AdmsDelete();
        $apagarCargo->exeDelete("adms_resp_autorizacao", "WHERE id =:id", "id={$this->DadosId}");
        if ($apagarCargo->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Cadastro apagado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O cadastro não foi apagado!</div>";
            $this->Resultado = false;
        }
    }

}
