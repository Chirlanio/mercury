<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsApagarTransf
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsApagarTransf {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarTransf($DadosId = null) {
        $this->DadosId = (int) $DadosId;

        $apagarTransf = new \App\adms\Models\helper\AdmsDelete();
        $apagarTransf->exeDelete("tb_transferencias", "WHERE id =:id", "id={$this->DadosId}");
        if ($apagarTransf->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Transferência apagada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A transferência não foi apagada!</div>";
            $this->Resultado = false;
        }
    }

}
