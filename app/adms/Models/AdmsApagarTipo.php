<?php

namespace App\adms\Models;

if (!defined('URLADM')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsApagarTipo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsApagarTipo {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarTipo($DadosId = null) {

        $this->DadosId = (int) $DadosId;

        $apagarTipo = new \App\adms\Models\helper\AdmsDelete();
        $apagarTipo->exeDelete("adms_tps_artigos", "WHERE id =:id", "id={$this->DadosId}");

        if ($apagarTipo->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Tipo de artigo apagado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O tipo de artigo não foi apagado!</div>";
            $this->Resultado = false;
        }
    }

}
