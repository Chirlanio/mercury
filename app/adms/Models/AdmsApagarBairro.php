<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsApagarBairro
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsApagarBairro {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarBairro($DadosId = null) {
        
        $this->DadosId = (int) $DadosId;
        
        $apagarBairro = new \App\adms\Models\helper\AdmsDelete();
        $apagarBairro->exeDelete("tb_bairros", "WHERE id =:id", "id={$this->DadosId}");
        
        if ($apagarBairro->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Bairro apagado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O bairro não foi apagado!</div>";
            $this->Resultado = false;
        }
    }

}
