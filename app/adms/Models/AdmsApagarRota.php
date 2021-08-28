<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsApagarRota
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsApagarRota {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarRota($DadosId = null) {
        
        $this->DadosId = (int) $DadosId;
        
        $apagarRota = new \App\adms\Models\helper\AdmsDelete();
        $apagarRota->exeDelete("tb_rotas", "WHERE id =:id", "id={$this->DadosId}");
        
        if ($apagarRota->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Rota apagada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A rota não foi apagada!</div>";
            $this->Resultado = false;
        }
    }

}
