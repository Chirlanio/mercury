<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsApagarFunc
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsApagarFunc {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarFunc($DadosId = null) {
        $this->DadosId = (int) $DadosId;

        $apagarFunc = new \App\adms\Models\helper\AdmsDelete();
        $apagarFunc->exeDelete("tb_funcionarios", "WHERE id =:id", "id={$this->DadosId}");
        if ($apagarFunc->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Cadastro apagado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O cadastro não foi apagado!</div>";
            $this->Resultado = false;
        }
    }

}
