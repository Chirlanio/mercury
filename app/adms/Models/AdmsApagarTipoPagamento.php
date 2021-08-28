<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsApagarTipoPagamento
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsApagarTipoPagamento {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarTipo($DadosId = null) {
        
        $this->DadosId = (int) $DadosId;
        
        $apagarBairro = new \App\adms\Models\helper\AdmsDelete();
        $apagarBairro->exeDelete("tb_forma_pag", "WHERE id =:id", "id={$this->DadosId}");
        
        if ($apagarBairro->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Tipo de pagamento apagado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O tipo de pagamento não foi apagado!</div>";
            $this->Resultado = false;
        }
    }

}
