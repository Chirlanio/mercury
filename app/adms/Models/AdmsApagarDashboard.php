<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsApagarDashboard
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsApagarDashboard {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarDashboard($DadosId = null) {
        $this->DadosId = (int) $DadosId;

        $apagarDash = new \App\adms\Models\helper\AdmsDelete();
        $apagarDash->exeDelete("tb_dashboards", "WHERE id =:id", "id={$this->DadosId}");
        if ($apagarDash->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Dashboard apagado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O Dashboard não foi apagado!</div>";
            $this->Resultado = false;
        }
    }

}
