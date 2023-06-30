<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsApagarLoja
 *
 * @copyright (c) year, Chirlanio Silva - Grupo Meia Sola
 */
class AdmsApagarLoja {

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarLoja($DadosId = null) {
        $this->DadosId = (int) $DadosId;

        $apagarDash = new \App\adms\Models\helper\AdmsDelete();
        $apagarDash->exeDelete("tb_lojas", "WHERE id_loja =:id_loja", "id_loja={$this->DadosId}");
        if ($apagarDash->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Loja apagada com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A loja não foi apagada!</div>";
            $this->Resultado = false;
        }
    }

}