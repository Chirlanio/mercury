<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsApagarTroca
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsApagarTroca {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarTroca($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $apagarTroca = new \App\adms\Models\helper\AdmsDelete();
        $apagarTroca->exeDelete("tb_cad_produtos", "WHERE id =:id", "id={$this->DadosId}");
        if ($apagarTroca->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Solicitação apagada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A solicitação não foi apagada!</div>";
            $this->Resultado = false;
        }
    }

}
