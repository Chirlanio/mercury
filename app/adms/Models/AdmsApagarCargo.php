<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsApagarCargo
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsApagarCargo {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarCargo($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $apagarCargo = new \App\adms\Models\helper\AdmsDelete();
        $apagarCargo->exeDelete("tb_cargos", "WHERE id =:id", "id={$this->DadosId}");
        if ($apagarCargo->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Cargo apagado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O cargo não foi apagado!</div>";
            $this->Resultado = false;
        }
    }

}
