<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsApagarAjuste
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsApagarAjuste {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarAjuste($DadosId = null) {
        $this->DadosId = (int) $DadosId;

        $apagarAjuste = new \App\adms\Models\helper\AdmsDelete();
        $apagarAjuste->exeDelete("tb_ajuste", "WHERE id =:id", "id={$this->DadosId}");
        if ($apagarAjuste->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Solicitação apagado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A Solicitação não foi apagado!</div>";
            $this->Resultado = false;
        }
    }

}
