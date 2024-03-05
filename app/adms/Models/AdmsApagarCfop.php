<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsApagarCfop
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsApagarCfop {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarCfop($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $apagarCfop = new \App\adms\Models\helper\AdmsDelete();
        $apagarCfop->exeDelete("adms_cfops", "WHERE id =:id", "id={$this->DadosId}");
        if ($apagarCfop->getResult()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Cfop apagado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O cfop não foi apagado!</div>";
            $this->Resultado = false;
        }
    }

}
