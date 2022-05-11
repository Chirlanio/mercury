<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsApagarDelivery
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsApagarDelivery {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarDelivery($DadosId = null) {
        $this->DadosId = (int) $DadosId;

        $apagarDelivery = new \App\adms\Models\helper\AdmsDelete();
        $apagarDelivery->exeDelete("tb_delivery", "WHERE id =:id", "id={$this->DadosId}");
        if ($apagarDelivery->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Pedido apagado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O pedido não foi apagado!</div>";
            $this->Resultado = false;
        }
    }

}
